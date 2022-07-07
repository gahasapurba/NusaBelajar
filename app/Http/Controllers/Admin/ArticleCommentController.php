<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ArticleCommentRequest;
use App\Mail\User\ArticleComment as UserArticleComment;
use App\Mail\Admin\ArticleComment as AdminArticleComment;

class ArticleCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCommentRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'article_articles_id' => $hash->decodeHex($request->article_articles_id),
                'comment' => $request->comment,
                'file' => $request->file('file')->store('upload/article_comment_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'article_articles_id' => $hash->decodeHex($request->article_articles_id),
                'comment' => $request->comment,
            ];
        }

        ArticleComment::create($data);
        $item = Article::findOrFail($data['article_articles_id']);

        if ($item->author_users_id != Auth::user()->id) {
            Notification::create([
                'receiver_users_id' => $item->author_users_id,
                'type' => 'article.index',
                'title' => 'Komentar Baru Pada Artikel Anda',
                'subtitle' => 'perlu dilihat',
                'content' => 'Komentar baru telah dikirim oleh seseorang pada artikel anda yang berjudul "{$item->title}"',
            ]);
            Mail::to($item->article_creator->email)->send(new UserArticleComment($item));
        }

        $administrators = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'article.index',
                'title' => 'Komentar Baru Pada Artikel',
                'subtitle' => 'perlu dilihat',
                'content' => 'Komentar baru telah dikirim oleh seseorang pada sebuah artikel yang berjudul "{$item->title}"',
            ]);
            Mail::to($administrator->email)->send(new AdminArticleComment($item));
        }

        return redirect()->back()->with('success', 'Komentar Artikel Berhasil Dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleComment::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Komentar Artikel Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.article_comment.trash');
    }

    public function trashArticleComment()
    {
        if(request()->ajax())
        {
            $queryArticleComment = ArticleComment::onlyTrashed()->orderBy('deleted_at', 'desc')->with('article_comment_creator', 'article_comment_commented_article');
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticleComment)
                ->addColumn('article_comment_creator', function (ArticleComment $article_comment) {
                    if ($article_comment->article_comment_creator->is_admin) {
                        return '
                            '.$article_comment->article_comment_creator->name.' - '.$article_comment->article_comment_creator->email.' (Administrator)
                        ';
                    } else if ($article_comment->article_comment_creator->is_mentor) {
                        return '
                            '.$article_comment->article_comment_creator->name.' - '.$article_comment->article_comment_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$article_comment->article_comment_creator->name.' - '.$article_comment->article_comment_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('article_comment_commented_article', function (ArticleComment $article_comment) {
                    return $article_comment->article_comment_commented_article->title;
                })
                ->addColumn('created_at', function (ArticleComment $article_comment) {
                    return $article_comment->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (ArticleComment $article_comment) {
                    return $article_comment->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (ArticleComment $article_comment) {
                    return $article_comment->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-article-comment-restore mx-auto" href="'.route('admin.article.comment.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.comment.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-comment-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['article_comment_creator', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleComment::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.article.comment.trash')->with('success', 'Komentar Artikel Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleComment::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.article.comment.trash')->with('success', 'Komentar Artikel Berhasil Dihapus Permanen!');
    }
}

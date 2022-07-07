<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ArticleCommentRequest;
use App\Mail\Admin\ArticleComment as AdminArticleComment;
use App\Mail\User\ArticleComment as UserArticleComment;

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

        $administrators = User::where('is_admin')->get();

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
        $item = ArticleComment::all()->where('sender_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Komentar Artikel Berhasil Dihapus!');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\Admin\Article as AdminArticle;
use App\Http\Requests\ArticleRequest\StoreArticleRequest;
use App\Http\Requests\ArticleRequest\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.article.index');
    }

    public function listArticle()
    {
        if(request()->ajax())
        {
            $queryArticle = Article::where('author_users_id', Auth::user()->id)->latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticle)
                ->addColumn('status', function (Article $article) {
                    if (!$article->is_accepted && !$article->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($article->is_accepted && !$article->is_rejected && $article->is_featured) {
                        return '<span class="status-btn success-btn">Artikel Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Artikel Direkomendasikan</span>';
                    } else if ($article->is_accepted && !$article->is_rejected) {
                        return '<span class="status-btn success-btn">Artikel Disetujui</span>';
                    } else if (!$article->is_accepted && $article->is_rejected) {
                        return '<span class="status-btn danger-btn">Artikel Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Article $article) {
                    return $article->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Article $article) {
                    return $article->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-article-show mx-auto" href="'.route('dashboard.article.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-article-edit mx-auto" href="'.route('dashboard.article.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.article.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-article-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'show', 'edit', 'delete'])
                ->make();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hash = new Hashids('', 10);
        $article_categories = ArticleCategory::all();
        $article_tags = ArticleTag::all();

        return view('pages.dashboard.article.create',[
            'hash' => $hash,
            'article_categories' => $article_categories,
            'article_tags' => $article_tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file') && $request->quote) {
            $data = [
                'author_users_id' => Auth::user()->id,
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'file' => $request->file('file')->store('upload/article_file','public'),
                'quote' => $request->quote,
            ];
        } else if (!$request->hasFile('file') && $request->quote) {
            $data = [
                'author_users_id' => Auth::user()->id,
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'quote' => $request->quote,
            ];
        } else if ($request->hasFile('file') && !$request->quote) {
            $data = [
                'author_users_id' => Auth::user()->id,
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'file' => $request->file('file')->store('upload/article_file','public'),
            ];
        } else {
            $data = [
                'author_users_id' => Auth::user()->id,
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
            ];
        }

        $item = Article::create($data);
        $item->article_tags()->attach($request->tag_article_tags_id);
        $administrators = User::where('is_admin', true)->get();
        
        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.article.index',
                'title' => 'Artikel Baru',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Artikel baru telah dikirim dan memerlukan peninjauan',
            ]);
            Mail::to($administrator->email)->send(new AdminArticle($hash, $item));
        }

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('author_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.article.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('author_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $article_categories = ArticleCategory::all();
        $article_tags = ArticleTag::all();

        return view('pages.dashboard.article.edit', [
            'hash' => $hash,
            'item' => $item,
            'article_categories' => $article_categories,
            'article_tags' => $article_tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('author_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        if ($request->hasFile('thumbnail') && $request->hasFile('file') && $request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'file' => $request->file('file')->store('upload/article_file','public'),
                'quote' => $request->quote,
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->file);
        } else if (!$request->hasFile('thumbnail') && $request->hasFile('file') && $request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'file' => $request->file('file')->store('upload/article_file','public'),
                'quote' => $request->quote,
            ];
            Storage::delete('public/'.$item->file);
        } else if ($request->hasFile('thumbnail') && !$request->hasFile('file') && $request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'quote' => $request->quote,
            ];
            Storage::delete('public/'.$item->thumbnail);
        } else if ($request->hasFile('thumbnail') && $request->hasFile('file') && !$request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
                'file' => $request->file('file')->store('upload/article_file','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->file);
        } else if (!$request->hasFile('thumbnail') && !$request->hasFile('file') && $request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'quote' => $request->quote,
            ];
        } else if ($request->hasFile('thumbnail') && !$request->hasFile('file') && !$request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'thumbnail' => $request->file('thumbnail')->store('upload/article_thumbnail','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
        } else if (!$request->hasFile('thumbnail') && $request->hasFile('file') && !$request->quote) {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'file' => $request->file('file')->store('upload/article_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'category_article_categories_id' => $hash->decodeHex($request->category_article_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
            ];
        }

        $item->update($data);
        $item->article_tags()->sync($request->tag_article_tags_id);

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel Berhasil Diubah!');
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
        $item = Article::all()->where('author_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.article.index')->with('success', 'Artikel Berhasil Dihapus!');
    }
}

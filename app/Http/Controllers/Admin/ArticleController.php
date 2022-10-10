<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest\ReviewArticleRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\User\Article as UserArticle;
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
        return view('pages.admin.article.index');
    }

    public function listArticle()
    {
        if(request()->ajax())
        {
            $queryArticle = Article::latest();
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
                            <a class="text-info admin-article-show mx-auto" href="'.route('admin.article.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-article-edit mx-auto" href="'.route('admin.article.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-destroy">
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $item = Article::findOrFail($hash->decodeHex($id));

        return view('pages.admin.article.show', [
            'item' => $item,
            'hash' => $hash,
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
        $item = Article::findOrFail($hash->decodeHex($id));
        $article_categories = ArticleCategory::all();
        $article_tags = ArticleTag::all();

        return view('pages.admin.article.edit', [
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
        $item = Article::findOrFail($hash->decodeHex($id));

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

        return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Diubah!');
    }

    public function review(ReviewArticleRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('is_accepted', false)->where('is_rejected', false)->find($hash->decodeHex($id));
        $receiver = User::findOrFail($item->author_users_id);

        switch ($request->input('action')) {
            case 'accept':
                $data = [
                    'is_accepted' => true,
                    'review' => $request->review,
                ];

                Notification::create([
                    'receiver_users_id' => $receiver->id,
                    'type' => 'dashboard.article.index',
                    'title' => 'Peninjauan Artikel Anda',
                    'subtitle' => 'telah diterima',
                    'content' => 'Selamat, artikel anda telah diterima untuk ditampilkan di website NusaBelajar',
                ]);
                Mail::to($receiver->email)->send(new UserArticle($hash, $item));

                break;

            case 'reject':
                $data = [
                    'is_rejected' => true,
                    'review' => $request->review,
                ];

                Notification::create([
                    'receiver_users_id' => $receiver->id,
                    'type' => 'dashboard.article.index',
                    'title' => 'Peninjauan Artikel Anda',
                    'subtitle' => 'telah ditolak',
                    'content' => 'Maaf, artikel anda telah ditolak untuk ditampilkan di website NusaBelajar',
                ]);
                Mail::to($receiver->email)->send(new UserArticle($hash, $item));
                
                break;
        }

        $item->update($data);

        return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Ditinjau!');
    }

    // public function accept(ReviewArticleRequest $request, $id)
    // {
    //     $hash = new Hashids('', 10);
    //     $item = Article::all()->where('is_accepted', false)->where('is_rejected', false)->find($hash->decodeHex($id));

    //     $data = [
    //         'is_accepted' => true,
    //         'review' => $request->review,
    //     ];

    //     $item->update($data);
    //     $receiver = User::findOrFail($item->author_users_id);

    //     Notification::create([
    //         'receiver_users_id' => $receiver->id,
    //         'type' => 'dashboard.article.index',
    //         'title' => 'Peninjauan Artikel Anda',
    //         'subtitle' => 'telah diterima',
    //         'content' => 'Selamat, artikel anda telah diterima untuk ditampilkan di website NusaBelajar',
    //     ]);
    //     Mail::to($receiver->email)->send(new UserArticle($hash, $item));

    //     return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Diterima!');
    // }
    
    // public function reject(ReviewArticleRequest $request, $id)
    // {
    //     $hash = new Hashids('', 10);
    //     $item = Article::all()->where('is_accepted', false)->where('is_rejected', false)->find($hash->decodeHex($id));

    //     $data = [
    //         'is_rejected' => true,
    //         'review' => $request->review,
    //     ];

    //     $item->update($data);
    //     $receiver = User::findOrFail($item->author_users_id);

    //     Notification::create([
    //         'receiver_users_id' => $receiver->id,
    //         'type' => 'dashboard.article.index',
    //         'title' => 'Peninjauan Artikel Anda',
    //         'subtitle' => 'telah ditolak',
    //         'content' => 'Maaf, artikel anda telah ditolak untuk ditampilkan di website NusaBelajar',
    //     ]);
    //     Mail::to($receiver->email)->send(new UserArticle($hash, $item));

    //     return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Ditolak!');
    // }
    
    public function feature($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('is_accepted')->where('is_rejected', false)->find($hash->decodeHex($id));

        $data = [
            'is_featured' => true,
        ];

        $item->update($data);

        return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Direkomendasikan!');
    }
    
    public function unfeature($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::all()->where('is_accepted')->where('is_featured')->find($hash->decodeHex($id));

        $data = [
            'is_featured' => false,
        ];

        $item->update($data);

        return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Dibatalkan Rekomendasinya!');
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
        $item = Article::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.article.index')->with('success', 'Artikel Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.article.trash');
    }

    public function trashArticle()
    {
        if(request()->ajax())
        {
            $queryArticle = Article::onlyTrashed()->orderBy('deleted_at', 'desc');
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
                    return $article->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Article $article) {
                    return $article->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Article $article) {
                    return $article->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-article-restore mx-auto" href="'.route('admin.article.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.article.trash')->with('success', 'Artikel Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Article::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->thumbnail);
        Storage::delete('public/'.$item->file);
        $item->article_tags()->detach();
        $item->forceDelete();

        return redirect()->route('admin.article.trash')->with('success', 'Artikel Berhasil Dihapus Permanen!');
    }
}

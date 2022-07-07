<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use App\Models\ArticleTag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleTagRequest;
use Yajra\DataTables\Facades\DataTables;

class ArticleTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.article_tag.index');
    }

    public function listArticleTag()
    {
        if(request()->ajax())
        {
            $queryArticleTag = ArticleTag::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticleTag)
                ->addColumn('created_at', function (ArticleTag $article_tag) {
                    return $article_tag->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (ArticleTag $article_tag) {
                    return $article_tag->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-article-tag-show mx-auto" href="'.route('admin.article.tag.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-article-tag-edit mx-auto" href="'.route('admin.article.tag.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.tag.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-tag-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['show', 'edit', 'delete'])
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
        return view('pages.admin.article_tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleTagRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        ArticleTag::create($data);

        return redirect()->route('admin.article.tag.index')->with('success', 'Tag Artikel Berhasil Dibuat!');
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
        $item = ArticleTag::findOrFail($hash->decodeHex($id));

        return view('pages.admin.article_tag.show', [
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
        $item = ArticleTag::findOrFail($hash->decodeHex($id));

        return view('pages.admin.article_tag.edit', [
            'hash' => $hash,
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleTagRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleTag::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $item->update($data);

        return redirect()->route('admin.article.tag.index')->with('success', 'Tag Artikel Berhasil Diubah!');
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
        $item = ArticleTag::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.article.tag.index')->with('success', 'Tag Artikel Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.article_tag.trash');
    }

    public function trashArticleTag()
    {
        if(request()->ajax())
        {
            $queryArticleTag = ArticleTag::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticleTag)
                ->addColumn('created_at', function (ArticleTag $article_tag) {
                    return $article_tag->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (ArticleTag $article_tag) {
                    return $article_tag->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (ArticleTag $article_tag) {
                    return $article_tag->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-article-tag-restore mx-auto" href="'.route('admin.article.tag.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.tag.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-tag-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleTag::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.article.tag.trash')->with('success', 'Tag Artikel Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleTag::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.article.tag.trash')->with('success', 'Tag Artikel Berhasil Dihapus Permanen!');
    }
}

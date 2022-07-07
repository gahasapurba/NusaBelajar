<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\ArticleTagged;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ArticleTaggedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.article_tagged.index');
    }

    public function listArticleTagged()
    {
        if(request()->ajax())
        {
            $queryArticleTagged = ArticleTagged::latest()->with('article_tagged', 'article_tag');
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticleTagged)
                ->addColumn('article_title', function (ArticleTagged $article_tagged) {
                    return $article_tagged->article_tagged->title;
                })
                ->addColumn('article_tag', function (ArticleTagged $article_tagged) {
                    return $article_tagged->article_tag->name;
                })
                ->addColumn('created_at', function (ArticleTagged $article_tagged) {
                    return $article_tagged->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (ArticleTagged $article_tagged) {
                    return $article_tagged->updated_at->diffForHumans();
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.tagged.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-tagged-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['delete'])
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
        $item = ArticleTagged::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.article.tagged.index')->with('success', 'Artikel Yang Ditag Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.article_tagged.trash');
    }

    public function trashArticleTagged()
    {
        if(request()->ajax())
        {
            $queryArticleTagged = ArticleTagged::onlyTrashed()->orderBy('deleted_at', 'desc')->with('article_tagged', 'article_tag');
            $hash = new Hashids('', 10);

            return DataTables::of($queryArticleTagged)
                ->addColumn('article_title', function (ArticleTagged $article_tagged) {
                    return $article_tagged->article_tagged->title;
                })
                ->addColumn('article_tag', function (ArticleTagged $article_tagged) {
                    return $article_tagged->article_tag->name;
                })
                ->addColumn('created_at', function (ArticleTagged $article_tagged) {
                    return $article_tagged->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (ArticleTagged $article_tagged) {
                    return $article_tagged->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (ArticleTagged $article_tagged) {
                    return $article_tagged->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-article-tagged-restore mx-auto" href="'.route('admin.article.tagged.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.article.tagged.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-article-tagged-kill">
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
        $item = ArticleTagged::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.article.tagged.trash')->with('success', 'Artikel Yang Ditag Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = ArticleTagged::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.article.tagged.trash')->with('success', 'Artikel Yang Ditag Berhasil Dihapus Permanen!');
    }
}

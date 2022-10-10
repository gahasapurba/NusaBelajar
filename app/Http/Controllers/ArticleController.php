<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Models\ArticleCategory;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest_articles = Article::where('is_accepted')->latest()->paginate(6);
        $featured_articles = Article::where('is_accepted')->where('is_featured')->inRandomOrder()->limit(3)->get();
        $article_categories = ArticleCategory::all();
        $article_tags = ArticleTag::all();

        return view('pages.homepage.article.index',[
            'latest_articles' => $latest_articles,
            'featured_articles' => $featured_articles,
            'article_categories' => $article_categories,
            'article_tags' => $article_tags,
        ]);
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
    public function show($slug)
    {
        $hash = new Hashids('', 10);
        $item = Article::where('is_accepted', true)->where('slug', $slug)->first();
        $article_comment_count = ArticleComment::where('article_articles_id', $item->id)->count();
        $article_comments = ArticleComment::where('article_articles_id', $item->id)->latest()->get();
        $item->increment('view');

        return view('pages.homepage.article.show', [
            'hash' => $hash,
            'item' => $item,
            'article_comment_count' => $article_comment_count,
            'article_comments' => $article_comments,
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
        //
    }

    public function category($slug)
    {
        $item = Article::where('is_accepted')->where('slug', $slug)->firstOrFail();
        $item->increment('view');

        return view('pages.homepage.article.show', [
            'item' => $item,
        ]);
    }
    
    public function tag($slug)
    {
        $item = Article::where('is_accepted')->where('slug', $slug)->firstOrFail();
        $item->increment('view');

        return view('pages.homepage.article.show', [
            'item' => $item,
        ]);
    }
}

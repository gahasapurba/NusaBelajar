<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Event;
use App\Models\Course;
use App\Models\Article;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Models\MentorVerification;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hash = new Hashids('', 10);
        $featured_courses = Course::where('is_accepted', true)->where('is_featured', true)->inRandomOrder()->limit(6)->get();
        $user_count = User::count();
        $course_count = Course::where('is_accepted', true)->count();
        $article_count = Article::where('is_accepted', true)->count();
        $discussion_count = Discussion::where('is_accepted', true)->count();
        $latest_events_with_thumbnail = Event::where('is_accepted', true)->latest()->limit(2)->get();
        $latest_events_without_thumbnail = Event::where('is_accepted', true)->latest()->skip(2)->take(2)->get();
        $mentors = MentorVerification::where('is_accepted', true)->inRandomOrder()->limit(4)->get();
        $testimonials = Questionnaire::inRandomOrder()->limit(7)->get();
        $popular_articles_left = Article::where('is_accepted', true)->orderBy('view', 'desc')->skip(1)->take(2)->get();
        $popular_articles_center = Article::where('is_accepted', true)->orderBy('view', 'desc')->limit(1)->get();
        $popular_articles_right = Article::where('is_accepted', true)->orderBy('view', 'desc')->skip(3)->take(2)->get();

        return view('pages.homepage.homepage',[
            'hash' => $hash,
            'featured_courses' => $featured_courses,
            'user_count' => $user_count,
            'course_count' => $course_count,
            'article_count' => $article_count,
            'discussion_count' => $discussion_count,
            'latest_events_with_thumbnail' => $latest_events_with_thumbnail,
            'latest_events_without_thumbnail' => $latest_events_without_thumbnail,
            'mentors' => $mentors,
            'testimonials' => $testimonials,
            'popular_articles_left' => $popular_articles_left,
            'popular_articles_center' => $popular_articles_center,
            'popular_articles_right' => $popular_articles_right,
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
        //
    }
}

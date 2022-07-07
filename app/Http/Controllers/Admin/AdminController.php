<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_count = User::count();
        $course_count = Course::where('is_accepted')->count();
        $article_count = Article::where('is_accepted')->count();
        $discussion_count = Discussion::where('is_accepted')->count();
        $latest_notifications = Notification::where('receiver_users_id', Auth::user()->id)->latest()->limit(8)->get();
        $latest_received_messages = Message::where('receiver_users_id', Auth::user()->id)->latest()->limit(8)->get();
        $latest_checkouts = Checkout::latest()->limit(6)->get();
        $latest_courses = Course::latest()->limit(4)->get();
        $latest_articles = Article::latest()->limit(4)->get();

        return view('pages.admin.admin',[
            'user_count' => $user_count,
            'course_count' => $course_count,
            'article_count' => $article_count,
            'discussion_count' => $discussion_count,
            'latest_notifications' => $latest_notifications,
            'latest_received_messages' => $latest_received_messages,
            'latest_checkouts' => $latest_checkouts,
            'latest_courses' => $latest_courses,
            'latest_articles' => $latest_articles,
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

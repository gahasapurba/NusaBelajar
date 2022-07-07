<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CourseReviewRequest;
use App\Mail\Admin\CourseReview as AdminCourseReview;
use App\Mail\User\CourseReview as UserCourseReview;

class CourseReviewController extends Controller
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
    public function store(CourseReviewRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'review' => $request->review,
                'file' => $request->file('file')->store('upload/course_review_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'review' => $request->review,
            ];
        }

        CourseReview::create($data);
        $item = Course::findOrFail($data['course_courses_id']);

        if ($item->mentor_users_id != Auth::user()->id) {
            Notification::create([
                'receiver_users_id' => $item->mentor_users_id,
                'type' => 'course.index',
                'title' => 'Review Baru Pada Kelas Anda',
                'subtitle' => 'perlu dilihat',
                'content' => 'Review baru telah dikirim oleh seseorang pada kelas anda yang berjudul "{$item->title}"',
            ]);
            Mail::to($item->course_creator->email)->send(new UserCourseReview($item));
        }

        $administrators = User::where('is_admin')->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'course.index',
                'title' => 'Review Baru Pada Artikel',
                'subtitle' => 'perlu dilihat',
                'content' => 'Review baru telah dikirim oleh seseorang pada sebuah kelas yang berjudul "{$item->title}"',
            ]);
            Mail::to($administrator->email)->send(new AdminCourseReview($item));
        }

        return redirect()->back()->with('success', 'Review Kelas Berhasil Dibuat!');
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
        $item = CourseReview::all()->where('sender_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Review Kelas Berhasil Dihapus!');
    }
}

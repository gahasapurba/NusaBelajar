<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseReviewRequest;
use App\Mail\User\CourseReview as UserCourseReview;
use App\Mail\Admin\CourseReview as AdminCourseReview;

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

        $administrators = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'course.index',
                'title' => 'Review Baru Pada Kelas',
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
        $item = CourseReview::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Review Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course_review.trash');
    }

    public function trashCourseReview()
    {
        if(request()->ajax())
        {
            $queryCourseReview = CourseReview::onlyTrashed()->orderBy('deleted_at', 'desc')->with('course_review_creator', 'course_review_reviewed_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseReview)
                ->addColumn('course_review_creator', function (CourseReview $course_review) {
                    if ($course_review->course_review_creator->is_admin) {
                        return '
                            '.$course_review->course_review_creator->name.' - '.$course_review->course_review_creator->email.' (Administrator)
                        ';
                    } else if ($course_review->course_review_creator->is_mentor) {
                        return '
                            '.$course_review->course_review_creator->name.' - '.$course_review->course_review_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$course_review->course_review_creator->name.' - '.$course_review->course_review_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('course_review_reviewed_course', function (CourseReview $course_review) {
                    return $course_review->course_review_reviewed_course->title;
                })
                ->addColumn('created_at', function (CourseReview $course_review) {
                    return $course_review->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (CourseReview $course_review) {
                    return $course_review->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (CourseReview $course_review) {
                    return $course_review->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-review-restore mx-auto" href="'.route('admin.course.review.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.review.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-review-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_review_creator', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseReview::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.review.trash')->with('success', 'Review Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseReview::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.course.review.trash')->with('success', 'Review Kelas Berhasil Dihapus Permanen!');
    }
}

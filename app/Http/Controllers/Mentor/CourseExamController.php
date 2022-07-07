<?php

namespace App\Http\Controllers\Mentor;

use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseExam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CourseExamRequest;
use Yajra\DataTables\Facades\DataTables;

class CourseExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course_exam.index');
    }

    public function listCourseExam()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $queryCourseExam = CourseExam::where('course_courses_id', $mentored_course->id)->latest()->with('course_exam_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseExam)
                ->addColumn('course_exam_course', function (CourseExam $course_exam) {
                    return $course_exam->course_exam_course->title;
                })
                ->addColumn('created_at', function (CourseExam $course_exam) {
                    return $course_exam->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseExam $course_exam) {
                    return $course_exam->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-exam-show mx-auto" href="'.route('dashboard.mentor.course.exam.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-exam-edit mx-auto" href="'.route('dashboard.mentor.course.exam.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.exam.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-exam-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_exam_course', 'show', 'edit', 'delete'])
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
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_exam.create',[
            'hash' => $hash,
            'courses' => $courses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseExamRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'question' => $request->question,
                'file' => $request->file('file')->store('upload/course_exam_file','public'),
            ];
        } else {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'question' => $request->question,
            ];
        }

        CourseExam::create($data);

        return redirect()->route('dashboard.mentor.course.exam.index')->with('success', 'Ujian Kelas Berhasil Dibuat!');
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
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseExam::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_exam.show', [
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
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseExam::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_exam.edit', [
            'hash' => $hash,
            'item' => $item,
            'courses' => $courses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseExamRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseExam::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'question' => $request->question,
                'file' => $request->file('file')->store('upload/course_exam_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'question' => $request->question,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.exam.index')->with('success', 'Ujian Kelas Berhasil Diubah!');
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
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseExam::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.exam.index')->with('success', 'Ujian Kelas Berhasil Dihapus!');
    }
}

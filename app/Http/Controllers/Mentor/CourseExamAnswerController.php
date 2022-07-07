<?php

namespace App\Http\Controllers\Mentor;

use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseExam;
use Illuminate\Http\Request;
use App\Models\CourseExamAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseExamAnswerRequest;

class CourseExamAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course_exam_answer.index');
    }

    public function listCourseExamAnswer()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $mentored_course_exam = CourseExam::all()->where('course_courses_id', $mentored_course->id);
            $queryCourseExamAnswer = CourseExamAnswer::where('exam_course_exams_id', $mentored_course_exam->id)->latest()->with('course_exam_answer_creator');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseExamAnswer)
                ->addColumn('course_exam_answer_creator', function (CourseExamAnswer $course_exam_answer) {
                    if ($course_exam_answer->course_exam_answer_creator->is_mentor) {
                        return '
                            '.$course_exam_answer->course_exam_answer_creator->name.' - '.$course_exam_answer->course_exam_answer_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$course_exam_answer->course_exam_answer_creator->name.' - '.$course_exam_answer->course_exam_answer_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (CourseExamAnswer $course_exam_answer) {
                    if (!$course_exam_answer->is_accepted && !$course_exam_answer->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($course_exam_answer->is_accepted && !$course_exam_answer->is_rejected) {
                        return '<span class="status-btn success-btn">Jawaban Ujian Kelas Benar</span>';
                    } else if (!$course_exam_answer->is_accepted && $course_exam_answer->is_rejected) {
                        return '<span class="status-btn danger-btn">Jawaban Ujian Kelas Salah</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (CourseExamAnswer $course_exam_answer) {
                    return $course_exam_answer->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseExamAnswer $course_exam_answer) {
                    return $course_exam_answer->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-exam-answer-show mx-auto" href="'.route('dashboard.mentor.course.exam.answer.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-exam-answer-edit mx-auto" href="'.route('dashboard.mentor.course.exam.answer.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.exam.answer.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-exam-answer-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_exam_answer_creator', 'status', 'show', 'edit', 'delete'])
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
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $mentored_course_exam = CourseExam::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseExamAnswer::all()->where('exam_course_exams_id', $mentored_course_exam->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_exam_answer.show', [
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
        $mentored_course_exam = CourseExam::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseExamAnswer::all()->where('exam_course_exams_id', $mentored_course_exam->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_exam_answer.edit', [
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
    public function update(CourseExamAnswerRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $mentored_course_exam = CourseExam::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseExamAnswer::all()->where('exam_course_exams_id', $mentored_course_exam->id)->findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'answer' => $request->answer,
                'file' => $request->file('file')->store('upload/course_exam_answer_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'answer' => $request->answer,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.exam.answer.index')->with('success', 'Jawaban Ujian Kelas Berhasil Diubah!');
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
        $mentored_course_exam = CourseExam::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseExamAnswer::all()->where('exam_course_exams_id', $mentored_course_exam->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.exam.answer.index')->with('success', 'Jawaban Ujian Kelas Berhasil Dihapus!');
    }
}

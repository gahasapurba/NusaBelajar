<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseExam;
use Illuminate\Http\Request;
use App\Models\CourseExamAnswer;
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
        return view('pages.admin.course_exam.index');
    }

    public function listCourseExam()
    {
        if(request()->ajax())
        {
            $queryCourseExam = CourseExam::latest()->with('course_exam_course');
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
                            <a class="text-info admin-course-exam-show mx-auto" href="'.route('admin.course.exam.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-exam-edit mx-auto" href="'.route('admin.course.exam.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.exam.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-exam-destroy">
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
        $item = CourseExamAnswer::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_exam_answer.show', [
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
        $item = CourseExamAnswer::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_exam_answer.edit', [
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
    public function update(CourseExamRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = CourseExamAnswer::findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'question' => $request->question,
                'file' => $request->file('file')->store('upload/course_exam_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'question' => $request->question,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.course.exam.index')->with('success', 'Ujian Kelas Berhasil Diubah!');
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
        $item = CourseExamAnswer::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.course.exam.index')->with('success', 'Ujian Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course_exam.trash');
    }

    public function trashCourseExam()
    {
        if(request()->ajax())
        {
            $queryCourseExam = CourseExam::onlyTrashed()->orderBy('deleted_at', 'desc')->with('course_exam_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseExam)
                ->addColumn('course_exam_course', function (CourseExam $course_exam) {
                    return $course_exam->course_exam_course->title;
                })
                ->addColumn('created_at', function (CourseExam $course_exam) {
                    return $course_exam->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (CourseExam $course_exam) {
                    return $course_exam->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (CourseExam $course_exam) {
                    return $course_exam->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-exam-restore mx-auto" href="'.route('admin.course.exam.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.exam.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-exam-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_exam_course', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseExamAnswer::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.exam.trash')->with('success', 'Ujian Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseExamAnswer::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.course.exam.trash')->with('success', 'Ujian Kelas Berhasil Dihapus Permanen!');
    }
}

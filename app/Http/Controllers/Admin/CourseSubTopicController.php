<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseSubTopic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseSubTopicRequest;

class CourseSubTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.course_sub_topic.index');
    }

    public function listCourseSubTopic()
    {
        if(request()->ajax())
        {
            $queryCourseSubTopic = CourseSubTopic::latest()->with('course_sub_topic_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseSubTopic)
                ->addColumn('course_sub_topic_course', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->course_subtopic_course->title;
                })
                ->addColumn('created_at', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-course-subtopic-show mx-auto" href="'.route('admin.course.subtopic.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-subtopic-edit mx-auto" href="'.route('admin.course.subtopic.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.subtopic.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-subtopic-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_sub_topic_course', 'show', 'edit', 'delete'])
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
        $item = CourseSubTopic::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_sub_topic.show', [
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
        $item = CourseSubTopic::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_sub_topic.edit', [
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
    public function update(CourseSubTopicRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = CourseSubTopic::findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/course_sub_topic_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.course.subtopic.index')->with('success', 'Sub Topik Kelas Berhasil Diubah!');
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
        $item = CourseSubTopic::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.course.subtopic.index')->with('success', 'Sub Topik Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course_sub_topic.trash');
    }

    public function trashCourseSubTopic()
    {
        if(request()->ajax())
        {
            $queryCourseSubTopic = CourseSubTopic::latest()->with('course_sub_topic_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseSubTopic)
                ->addColumn('course_sub_topic_course', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->course_subtopic_course->title;
                })
                ->addColumn('created_at', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (CourseSubTopic $course_sub_topic) {
                    return $course_sub_topic->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-subtopic-restore mx-auto" href="'.route('admin.course.subtopic.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.subtopic.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-subtopic-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_sub_topic_course', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseSubTopic::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.subtopic.trash')->with('success', 'Sub Topik Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseSubTopic::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.course.subtopic.trash')->with('success', 'Sub Topik Kelas Berhasil Dihapus Permanen!');
    }
}

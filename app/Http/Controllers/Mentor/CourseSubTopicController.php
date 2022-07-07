<?php

namespace App\Http\Controllers\Mentor;

use Hashids\Hashids;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseSubTopic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        return view('pages.dashboard.mentor.course_sub_topic.index');
    }

    public function listCourseSubTopic()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $queryCourseSubTopic = CourseSubTopic::where('course_courses_id', $mentored_course->id)->latest()->with('course_sub_topic_course');
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
                            <a class="text-info dashboard-mentor-course-subtopic-show mx-auto" href="'.route('dashboard.mentor.course.subtopic.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-subtopic-edit mx-auto" href="'.route('dashboard.mentor.course.subtopic.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.subtopic.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-subtopic-destroy">
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
        $hash = new Hashids('', 10);
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_sub_topic.create',[
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
    public function store(CourseSubTopicRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/course_sub_topic_file','public'),
            ];
        } else {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
            ];
        }

        CourseSubTopic::create($data);

        return redirect()->route('dashboard.mentor.course.subtopic.index')->with('success', 'Sub Topik Kelas Berhasil Dibuat!');
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
        $item = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_sub_topic.show', [
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
        $item = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_sub_topic.edit', [
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
    public function update(CourseSubTopicRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/course_sub_topic_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'course_courses_id' => $hash->decodeHex($request->course_courses_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.subtopic.index')->with('success', 'Sub Topik Kelas Berhasil Diubah!');
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
        $item = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.subtopic.index')->with('success', 'Sub Topik Kelas Berhasil Dihapus!');
    }
}

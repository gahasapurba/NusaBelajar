<?php

namespace App\Http\Controllers\Mentor;

use Hashids\Hashids;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseMaterial;
use App\Models\CourseSubTopic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseMaterialRequest;

class CourseMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course_material.index');
    }

    public function listCourseMaterial()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $mentored_sub_topic = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id);
            $queryCourseMaterial = CourseMaterial::where('sub_topic_course_sub_topics_id', $mentored_sub_topic->id)->latest()->with('course_material_course_sub_topic.course_sub_topic_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseMaterial)
                ->addColumn('course_sub_topic_course', function (CourseMaterial $course_material) {
                    return $course_material->course_sub_topic_course->title;
                })
                ->addColumn('created_at', function (CourseMaterial $course_material) {
                    return $course_material->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseMaterial $course_material) {
                    return $course_material->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-material-show mx-auto" href="'.route('dashboard.mentor.course.material.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-material-edit mx-auto" href="'.route('dashboard.mentor.course.material.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.material.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-material-destroy">
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
        $course_sub_topics = CourseSubTopic::all()->course_sub_topic_course()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_material.create',[
            'hash' => $hash,
            'course_sub_topics' => $course_sub_topics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseMaterialRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sub_topic_course_sub_topics_id' => $hash->decodeHex($request->sub_topic_course_sub_topics_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'file' => $request->file('file')->store('upload/course_material_file','public'),
                'estimated_time' => $request->estimated_time,
            ];
        } else {
            $data = [
                'sub_topic_course_sub_topics_id' => $hash->decodeHex($request->sub_topic_course_sub_topics_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'estimated_time' => $request->estimated_time,
            ];
        }

        CourseMaterial::create($data);

        return redirect()->route('dashboard.mentor.course.material.index')->with('success', 'Materi Kelas Berhasil Dibuat!');
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
        $mentored_sub_topic = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseMaterial::all()->where('sub_topic_course_sub_topics_id', $mentored_sub_topic->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_material.show', [
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
        $mentored_sub_topic = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseMaterial::all()->where('sub_topic_course_sub_topics_id', $mentored_sub_topic->id)->findOrFail($hash->decodeHex($id));
        $course_sub_topics = CourseSubTopic::all()->course_sub_topic_course()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_material.edit', [
            'hash' => $hash,
            'item' => $item,
            'course_sub_topics' => $course_sub_topics,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseMaterialRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $mentored_sub_topic = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseMaterial::all()->where('sub_topic_course_sub_topics_id', $mentored_sub_topic->id)->findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'sub_topic_course_sub_topics_id' => $hash->decodeHex($request->sub_topic_course_sub_topics_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'file' => $request->file('file')->store('upload/course_material_file','public'),
                'estimated_time' => $request->estimated_time,
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'sub_topic_course_sub_topics_id' => $hash->decodeHex($request->sub_topic_course_sub_topics_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'estimated_time' => $request->estimated_time,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.material.index')->with('success', 'Materi Kelas Berhasil Diubah!');
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
        $mentored_sub_topic = CourseSubTopic::all()->where('course_courses_id', $mentored_course->id);
        $item = CourseMaterial::all()->where('sub_topic_course_sub_topics_id', $mentored_sub_topic->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.material.index')->with('success', 'Materi Kelas Berhasil Dihapus!');
    }
}

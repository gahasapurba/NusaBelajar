<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\Admin\Course as AdminCourse;
use App\Http\Requests\CourseRequest\StoreCourseRequest;
use App\Http\Requests\CourseRequest\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course.index');
    }

    public function listCourse()
    {
        if(request()->ajax())
        {
            $queryCourse = Course::where('mentor_users_id', Auth::user()->id)->latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourse)
                ->addColumn('status', function (Course $course) {
                    if (!$course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($course->is_accepted && !$course->is_rejected && $course->is_featured) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Kelas Direkomendasikan</span>';
                    } else if ($course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span>';
                    } else if (!$course->is_accepted && $course->is_rejected) {
                        return '<span class="status-btn danger-btn">Kelas Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Course $course) {
                    return $course->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Course $course) {
                    return $course->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-show mx-auto" href="'.route('dashboard.mentor.course.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-edit mx-auto" href="'.route('dashboard.mentor.course.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'show', 'edit', 'delete'])
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
        $course_categories = CourseCategory::all();

        return view('pages.dashboard.mentor.course.create',[
            'hash' => $hash,
            'course_categories' => $course_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'mentor_users_id' => Auth::user()->id,
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
                'file' => $request->file('file')->store('upload/course_file','public'),
            ];
        } else {
            $data = [
                'mentor_users_id' => Auth::user()->id,
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
            ];
        }

        $item = Course::create($data);
        $administrators = User::where('is_admin', true)->get();
        
        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.course.index',
                'title' => 'Kelas Baru',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Kelas baru telah dikirim dan memerlukan peninjauan',
            ]);
            Mail::to($administrator->email)->send(new AdminCourse($hash, $item));
        }

        return redirect()->route('dashboard.mentor.course.index')->with('success', 'Kelas Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
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
        $item = Course::all()->where('mentor_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course.show', [
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
        $item = Course::all()->where('mentor_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $course_categories = CourseCategory::all();

        return view('pages.dashboard.mentor.course.edit', [
            'hash' => $hash,
            'item' => $item,
            'course_categories' => $course_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Course::all()->where('mentor_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        if ($request->hasFile('thumbnail') && $request->hasFile('syllabus') && $request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
                'file' => $request->file('file')->store('upload/course_file','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->syllabus);
            Storage::delete('public/'.$item->file);
        } else if (!$request->hasFile('thumbnail') && $request->hasFile('syllabus') && $request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
                'file' => $request->file('file')->store('upload/course_file','public'),
            ];
            Storage::delete('public/'.$item->syllabus);
            Storage::delete('public/'.$item->file);
        } else if ($request->hasFile('thumbnail') && !$request->hasFile('syllabus') && $request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'file' => $request->file('file')->store('upload/course_file','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->file);
        } else if ($request->hasFile('thumbnail') && $request->hasFile('syllabus') && !$request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->syllabus);
        } else if (!$request->hasFile('thumbnail') && !$request->hasFile('syllabus') && $request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'file' => $request->file('file')->store('upload/course_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else if ($request->hasFile('thumbnail') && !$request->hasFile('syllabus') && !$request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/course_thumbnail','public'),
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
            ];
            Storage::delete('public/'.$item->thumbnail);
        } else if (!$request->hasFile('thumbnail') && $request->hasFile('syllabus') && !$request->hasFile('file')) {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
                'syllabus' => $request->file('syllabus')->store('upload/course_syllabus','public'),
            ];
            Storage::delete('public/'.$item->syllabus);
        } else {
            $data = [
                'category_course_categories_id' => $hash->decodeHex($request->category_course_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'price' => $request->price,
                'description' => $request->description,
                'introduction_youtube_video_link' => $request->introduction_youtube_video_link,
                'telegram_group_link' => $request->telegram_group_link,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.index')->with('success', 'Kelas Berhasil Diubah!');
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
        $item = Course::all()->where('mentor_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.index')->with('success', 'Kelas Berhasil Dihapus!');
    }
}

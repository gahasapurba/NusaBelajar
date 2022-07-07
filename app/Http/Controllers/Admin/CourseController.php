<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Mail\Mentor\Course as MentorCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.course.index');
    }

    public function listCourse()
    {
        if(request()->ajax())
        {
            $queryCourse = Course::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourse)
                ->addColumn('status', function (Course $course) {
                    if (!$course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span>';
                    } else if ($course->is_accepted && !$course->is_rejected && $course->is_featured) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span><span class="status-btn secondary-btn">Kelas Direkomendasikan</span>';
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
                            <a class="text-info admin-course-show mx-auto" href="'.route('admin.course.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-edit mx-auto" href="'.route('admin.course.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-destroy">
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
        $item = Course::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course.show', [
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
        $item = Course::findOrFail($hash->decodeHex($id));
        $course_categories = CourseCategory::all();

        return view('pages.admin.course.edit', [
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
    public function update(CourseRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Course::findOrFail($hash->decodeHex($id));

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

        return redirect()->route('admin.course.index')->with('success', 'Kelas Berhasil Diubah!');
    }

    public function accept(CourseRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Course::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        if ($request->review) {
            $data = [
                'is_accepted' => true,
                'review' => $request->review,
            ];
        } else {
            $data = [
                'is_accepted' => true,
            ];
        }

        $item->update($data);
        $receiver = User::findOrFail($item->mentor_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.mentor.course.index',
            'title' => 'Peninjauan Kelas Anda',
            'subtitle' => 'telah diterima',
            'content' => 'Selamat, kelas anda telah diterima untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new MentorCourse($hash, $item));

        return redirect()->route('admin.course.index')->with('success', 'Kelas Berhasil Diterima!');
    }
    
    public function reject(CourseRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Course::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        if ($request->review) {
            $data = [
                'is_rejected' => true,
                'review' => $request->review,
            ];
        } else {
            $data = [
                'is_rejected' => true,
            ];
        }

        $item->update($data);
        $receiver = User::findOrFail($item->mentor_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.mentor.course.index',
            'title' => 'Peninjauan Kelas Anda',
            'subtitle' => 'telah ditolak',
            'content' => 'Maaf, kelas anda telah ditolak untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new MentorCourse($hash, $item));

        return redirect()->route('admin.article.index')->with('success', 'Kelas Berhasil Ditolak!');
    }
    
    public function featured($id)
    {
        $hash = new Hashids('', 10);
        $item = Course::all()->where('is_accepted')->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        $data = [
            'is_featured' => true,
        ];

        $item->update($data);

        return redirect()->route('admin.article.index')->with('success', 'Kelas Berhasil Direkomendasikan!');
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
        $item = Course::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.course.index')->with('success', 'Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course.trash');
    }

    public function trashCourse()
    {
        if(request()->ajax())
        {
            $queryCourse = Course::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourse)
                ->addColumn('status', function (Course $course) {
                    if (!$course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($course->is_accepted && !$course->is_rejected) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span>';
                    } else if ($course->is_accepted && !$course->is_rejected && $course->is_featured) {
                        return '<span class="status-btn success-btn">Kelas Disetujui</span><span class="status-btn secondary-btn">Kelas Direkomendasikan</span>';
                    } else if (!$course->is_accepted && $course->is_rejected) {
                        return '<span class="status-btn danger-btn">Kelas Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Course $course) {
                    return $course->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Course $course) {
                    return $course->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Course $course) {
                    return $course->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-restore mx-auto" href="'.route('admin.course.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Course::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.trash')->with('success', 'Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Course::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->thumbnail);
        Storage::delete('public/'.$item->syllabus);
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.course.trash')->with('success', 'Kelas Berhasil Dihapus Permanen!');
    }
}

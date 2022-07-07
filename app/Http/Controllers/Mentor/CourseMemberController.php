<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use App\Models\CourseMember;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseMemberRequest;
use App\Mail\User\CourseMember as UserCourseMember;

class CourseMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course_member.index');
    }

    public function listCourseMember()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $queryCourseMember = CourseMember::where('course_member_registered_course', $mentored_course->id)->latest()->with('course_member_registered_member', 'course_member_registered_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseMember)
                ->addColumn('course_member_registered_member', function (CourseMember $course_member) {
                    if ($course_member->course_member_registered_member->is_mentor) {
                        return '
                            '.$course_member->course_member_registered_member->name.' - '.$course_member->course_member_registered_member->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$course_member->course_member_registered_member->name.' - '.$course_member->course_member_registered_member->email.' (User)
                        ';
                    }
                })
                ->addColumn('course_member_registered_course', function (CourseMember $course_member) {
                    return $course_member->course_member_registered_course->title;
                })
                ->addColumn('created_at', function (CourseMember $course_member) {
                    return $course_member->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseMember $course_member) {
                    return $course_member->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-member-show mx-auto" href="'.route('dashboard.mentor.course.member.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-member-edit mx-auto" href="'.route('dashboard.mentor.course.member.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.member.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-member-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_member_registered_member', 'show', 'edit', 'delete'])
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
        $users = User::all()->where('is_admin', false)->whereNotIn('id', Auth::user()->id);
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_member.create',[
            'hash' => $hash,
            'users' => $users,
            'courses' => $courses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseMemberRequest $request)
    {
        $hash = new Hashids('', 10);

        $data = [
            'member_users_id' => $hash->decodeHex($request->member_users_id),
            'course_courses_id' => $hash->decodeHex($request->course_courses_id),
        ];

        $item = CourseMember::create($data);

        $receiver = User::findOrFail($item->member_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.course.member.index',
            'title' => 'Pendaftaran Kelas',
            'subtitle' => 'telah diterima',
            'content' => 'Selamat! anda telah diterima untuk didaftarkan pada sebuah kelas',
        ]);
        Mail::to($receiver->email)->send(new UserCourseMember($hash, $item));

        return redirect()->route('dashboard.mentor.course.member.index')->with('success', 'Anggota Kelas Berhasil Dibuat!');
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
        $item = CourseMember::all()->where('course_member_registered_course', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_member.show', [
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
        $item = CourseMember::all()->where('course_member_registered_course', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id)->where('is_accepted');

        return view('pages.dashboard.mentor.course_member.edit', [
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
    public function update(CourseMemberRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseMember::all()->where('course_member_registered_course', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        $data = [
            'course_courses_id' => $hash->decodeHex($request->course_courses_id),
        ];

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.member.index')->with('success', 'Anggota Kelas Berhasil Diubah!');
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
        $item = CourseMember::all()->where('course_member_registered_course', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.member.index')->with('success', 'Anggota Kelas Berhasil Dihapus!');
    }
}

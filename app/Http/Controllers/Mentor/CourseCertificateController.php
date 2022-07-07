<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Course;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CourseCertificate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseCertificateRequest;
use App\Mail\User\CourseCertificate as UserCourseCertificate;

class CourseCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor.course_certificate.index');
    }

    public function listCourseCertificate()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $queryCourseCertificate = CourseCertificate::where('course_courses_id', $mentored_course->id)->latest()->with('course_certificate_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseCertificate)
                ->addColumn('course_certificate_receiver', function (CourseCertificate $course_certificate) {
                    if ($course_certificate->course_certificate_receiver->is_mentor) {
                        return '
                            '.$course_certificate->course_certificate_receiver->name.' - '.$course_certificate->course_certificate_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$course_certificate->course_certificate_receiver->name.' - '.$course_certificate->course_certificate_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('created_at', function (CourseCertificate $course_certificate) {
                    return $course_certificate->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseCertificate $course_certificate) {
                    return $course_certificate->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-mentor-course-certificate-show mx-auto" href="'.route('dashboard.mentor.course.certificate.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-course-certificate-edit mx-auto" href="'.route('dashboard.mentor.course.certificate.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.course.certificate.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-course-certificate-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_certificate_receiver', 'show', 'edit', 'delete'])
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
        $users = User::all()->where('is_dashboard.mentor', false)->whereNotIn('id', Auth::user()->id);
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id);

        return view('pages.dashboard.mentor.course_certificate.create',[
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
    public function store(CourseCertificateRequest $request)
    {
        $hash = new Hashids('', 10);

        $item = CourseCertificate::create([
            'receiver_users_id' => $hash->decodeHex($request->receiver_users_id),
            'course_courses_id' => $hash->decodeHex($request->course_courses_id),
            'certificate_id' => $hash->encodeHex($this->create($request)->id),
        ]);

        $receiver = User::findOrFail($item->receiver_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.course.certificate.index',
            'title' => 'Sertifikat Diterbitkan',
            'subtitle' => 'perlu dilihat',
            'content' => 'Sertifikat kelulusan anda pada sebuah kelas telah diterbitkan',
        ]);
        Mail::to($receiver->email)->send(new UserCourseCertificate($hash, $item));

        return redirect()->route('dashboard.mentor.course.certificate.index')->with('success', 'Sertifikat Kelas Berhasil Dibuat!');
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
        $item = CourseCertificate::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.course_certificate.show', [
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
        $item = CourseCertificate::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $courses = Course::all()->where('mentor_users_id', Auth::user()->id);

        return view('pages.dashboard.mentor.course_certificate.edit', [
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
    public function update(CourseCertificateRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = CourseCertificate::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        $data = [
            'course_courses_id' => $hash->decodeHex($request->course_courses_id),
        ];

        $item->update($data);

        return redirect()->route('dashboard.mentor.course.certificate.index')->with('success', 'Sertifikat Kelas Berhasil Diubah!');
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
        $item = CourseCertificate::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.course.certificate.index')->with('success', 'Sertifikat Kelas Berhasil Dihapus!');
    }
}

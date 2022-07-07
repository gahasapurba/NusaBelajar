<?php

namespace App\Http\Controllers\User;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\CourseCertificate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CourseCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.course_certificate.index');
    }

    public function listCourseCertificate()
    {
        if(request()->ajax())
        {
            $queryCourseCertificate = CourseCertificate::where('receiver_users_id', Auth::user()->id)->latest()->with('course_certificate_receiver');
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
                            <a class="text-info dashboard-course-certificate-show mx-auto" href="'.route('dashboard.course.certificate.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.course.certificate.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-course-certificate-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_certificate_receiver', 'show', 'delete'])
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
        $item = CourseCertificate::all()->where('receiver_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.course_certificate.show', [
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $item = CourseCertificate::all()->where('receiver_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.course.certificate.index')->with('success', 'Sertifikat Kelas Berhasil Dihapus!');
    }
}

<?php

namespace App\Http\Controllers\User;

use Hashids\Hashids;
use App\Models\CourseMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CourseMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.course_member.index');
    }

    public function listCourseMember()
    {
        if(request()->ajax())
        {
            $queryCourseMember = CourseMember::where('member_users_id', Auth::user()->id)->latest()->with('course_member_registered_member', 'course_member_registered_course');
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
                            <a class="text-info dashboard-course-member-show mx-auto" href="'.route('dashboard.course.member.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-course-member-edit mx-auto" href="'.route('dashboard.course.member.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.course.member.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-course-member-destroy">
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
        $item = CourseMember::all()->where('member_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.course_member.show', [
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
        //
    }
}

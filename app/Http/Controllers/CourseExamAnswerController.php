<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\CourseExam;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CourseExamAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CourseExamRequest;
use App\Mail\Mentor\CourseExamAnswer as MentorCourseExamAnswer;
use App\Models\CourseMember;

class CourseExamAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hash = new Hashids('', 10);
        $registered_courses = CourseMember::where('member_users_id', Auth::user()->id);
        $course_exams = CourseExam::where('course_courses_id', $registered_courses->course_courses_id);

        return view('pages.homepage.course_exam_answer.create',[
            'hash' => $hash,
            'course_exams' => $course_exams,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseExamRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'exam_course_exams_id' => $hash->decodeHex($request->exam_course_exams_id),
                'answer' => $request->answer,
                'file' => $request->file('file')->store('upload/course_exam_answer_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'exam_course_exams_id' => $hash->decodeHex($request->exam_course_exams_id),
                'answer' => $request->answer,
            ];
        }

        CourseExamAnswer::create($data);
        $item = CourseExam::findOrFail($data['exam_course_exams_id']);

        if ($item->course_exam_course->mentor_users_id != Auth::user()->id) {
            Notification::create([
                'receiver_users_id' => $item->mentor_users_id,
                'type' => 'dashboard.mentor.course.exam.answer.index',
                'title' => 'Jawaban Baru Pada Ujian Kelas Anda',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Jawaban baru telah dikirim oleh seseorang pada ujian kelas anda yang berjudul "{$item->course_exam_course->title}"',
            ]);
            Mail::to($item->course_exam_course->course_creator->email)->send(new MentorCourseExamAnswer($hash, $item));
        }

        return redirect()->back()->with('success', 'Jawaban Ujian Kelas Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Mentor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

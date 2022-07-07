<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\QuestionnaireRequest;
use App\Mail\Admin\Questionnaire as AdminQuestionnaire;

class QuestionnaireController extends Controller
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
        return view('pages.homepage.questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionnaireRequest $request)
    {
        $hash = new Hashids('', 10);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
            'testimonial' => $request->testimonial,
        ];

        $item = Questionnaire::create($data);

        $administrators = User::where('is_admin', true)->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.questionnaire.index',
                'title' => 'Kuesioner Baru',
                'subtitle' => 'perlu dilihat',
                'content' => 'Kuesioner baru telah dikirim oleh pengunjung website',
            ]);
            Mail::to($administrator->email)->send(new AdminQuestionnaire($hash, $item));
        }

        return redirect()->route('questionnaire.create')->with('success', 'Kuesioner Berhasil Dibuat. Terima Kasih Sudah Mengisi Kuesioner di NusaBelajar');
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

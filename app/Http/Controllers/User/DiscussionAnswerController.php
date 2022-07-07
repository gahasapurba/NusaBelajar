<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Discussion;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\DiscussionAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DiscussionAnswerRequest;
use App\Mail\Admin\DiscussionAnswer as AdminDiscussionAnswer;
use App\Mail\User\DiscussionAnswer as UserDiscussionAnswer;

class DiscussionAnswerController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscussionAnswerRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'discussion_discussions_id' => $hash->decodeHex($request->discussion_discussions_id),
                'answer' => $request->answer,
                'file' => $request->file('file')->store('upload/discussion_answer_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'discussion_discussions_id' => $hash->decodeHex($request->discussion_discussions_id),
                'answer' => $request->answer,
            ];
        }

        DiscussionAnswer::create($data);
        $item = Discussion::findOrFail($data['discussion_discussions_id']);

        if ($item->sender_users_id != Auth::user()->id) {
            Notification::create([
                'receiver_users_id' => $item->sender_users_id,
                'type' => 'discussion.index',
                'title' => 'Jawaban Baru Pada Diskusi Anda',
                'subtitle' => 'perlu dilihat',
                'content' => 'Jawaban baru telah dikirim oleh seseorang pada diskusi anda yang berjudul "{$item->title}"',
            ]);
            Mail::to($item->discussion_creator->email)->send(new UserDiscussionAnswer($item));
        }

        $administrators = User::where('is_admin')->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'discussion.index',
                'title' => 'Jawaban Baru Pada Diskusi',
                'subtitle' => 'perlu dilihat',
                'content' => 'Jawaban baru telah dikirim oleh seseorang pada sebuah diskusi yang berjudul "{$item->title}"',
            ]);
            Mail::to($administrator->email)->send(new AdminDiscussionAnswer($item));
        }

        return redirect()->back()->with('success', 'Jawaban Diskusi Berhasil Dibuat!');
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
        $hash = new Hashids('', 10);
        $item = DiscussionAnswer::all()->where('sender_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Jawaban Diskusi Berhasil Dihapus!');
    }
}

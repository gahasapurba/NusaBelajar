<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Discussion;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\DiscussionAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DiscussionAnswerRequest;
use App\Mail\User\DiscussionAnswer as UserDiscussionAnswer;
use App\Mail\Admin\DiscussionAnswer as AdminDiscussionAnswer;

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

        $administrators = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->get();

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
        $item = DiscussionAnswer::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->back()->with('success', 'Jawaban Diskusi Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.discussion_answer.trash');
    }

    public function trashDiscussionAnswer()
    {
        if(request()->ajax())
        {
            $queryDiscussionAnswer = DiscussionAnswer::onlyTrashed()->orderBy('deleted_at', 'desc')->with('discussion_answer_creator', 'discussion_answer_answered_discussion');
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussionAnswer)
                ->addColumn('discussion_answer_creator', function (DiscussionAnswer $discussion_answer) {
                    if ($discussion_answer->discussion_answer_creator->is_admin) {
                        return '
                            '.$discussion_answer->discussion_answer_creator->name.' - '.$discussion_answer->discussion_answer_creator->email.' (Administrator)
                        ';
                    } else if ($discussion_answer->discussion_answer_creator->is_mentor) {
                        return '
                            '.$discussion_answer->discussion_answer_creator->name.' - '.$discussion_answer->discussion_answer_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$discussion_answer->discussion_answer_creator->name.' - '.$discussion_answer->discussion_answer_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('discussion_answer_answered_discussion', function (DiscussionAnswer $discussion_answer) {
                    return $discussion_answer->discussion_answer_answered_discussion->title;
                })
                ->addColumn('created_at', function (DiscussionAnswer $discussion_answer) {
                    return $discussion_answer->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (DiscussionAnswer $discussion_answer) {
                    return $discussion_answer->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (DiscussionAnswer $discussion_answer) {
                    return $discussion_answer->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discussion-answer-restore mx-auto" href="'.route('admin.discussion.answer.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discussion.answer.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discussion-answer-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['discussion_answer_creator', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = DiscussionAnswer::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.discussion.answer.trash')->with('success', 'Jawaban Diskusi Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = DiscussionAnswer::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.discussion.answer.trash')->with('success', 'Jawaban Diskusi Berhasil Dihapus Permanen!');
    }
}

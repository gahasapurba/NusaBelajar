<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmailSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EmailBroadcastRequest;
use App\Mail\EmailBroadcast;

class EmailBroadcastController extends Controller
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
        $users = User::all()->whereNotIn('id', Auth::user()->id);
        return view('pages.admin.email_broadcast.create',[
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailBroadcastRequest $request)
    {
        $only_subscribers = EmailSubscription::all();
        $only_administrators = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->get();
        $only_mentors = User::where('is_mentor')->get();
        $only_users = User::where('is_admin', false)->where('is_mentor', false)->get();
        $administrators_and_mentors = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->where('is_mentor')->get();
        $mentors_and_users = User::where('is_admin', false)->get();
        $administrators_and_users = User::where('is_admin')->whereNotIn('id', Auth::user()->id)->where('is_mentor', false)->get();

        if ($request->receiver == 'only_subscribers') {
            foreach ($only_subscribers as $only_subscriber) {
                Mail::to($only_subscriber->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'only_administrators') {
            foreach ($only_administrators as $only_administrator) {
                Mail::to($only_administrator->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'only_mentors') {
            foreach ($only_mentors as $only_mentor) {
                Mail::to($only_mentor->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'only_users') {
            foreach ($only_users as $only_user) {
                Mail::to($only_user->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'administrators_and_mentors') {
            foreach ($administrators_and_mentors as $administrators_and_mentor) {
                Mail::to($administrators_and_mentor->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'mentors_and_users') {
            foreach ($mentors_and_users as $mentors_and_user) {
                Mail::to($mentors_and_user->email)->send(new EmailBroadcast($request));
            }
        } elseif ($request->receiver == 'administrators_and_users') {
            foreach ($administrators_and_users as $administrators_and_user) {
                Mail::to($administrators_and_user->email)->send(new EmailBroadcast($request));
            }
        } else {
            Mail::to($request->receiver)->send(new EmailBroadcast($request));
        }

        return redirect()->route('admin.email.broadcast.create')->with('success', 'Email Berhasil Dibuat!');
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

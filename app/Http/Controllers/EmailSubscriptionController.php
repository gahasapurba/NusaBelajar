<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSubscription;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EmailSubscriptionRequest;
use App\Mail\EmailSubscription as MailEmailSubscription;

class EmailSubscriptionController extends Controller
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
    public function store(EmailSubscriptionRequest $request)
    {
        $data = [
            'email' => $request->email,
        ];

        $item = EmailSubscription::create($data);

        Mail::to($item->email)->send(new MailEmailSubscription($item));

        return redirect()->back()->with('success', 'Email Berlangganan Berhasil Dibuat. Terima Kasih Sudah Berlangganan di NusaBelajar');
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

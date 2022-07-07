<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hash = new Hashids('', 10);
        $item = Auth::user();

        return view('pages.dashboard.user.index', [
            'hash' => $hash,
            'item' => $item,
        ]);
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
    public function update(UserRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = User::all()->where('id', Auth::user()->id)->findOrFail($hash->decodeHex($id));

        if ($request->phone_number && $request->address && $request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'avatar' => $request->file('avatar')->store('upload/user_avatar','public'),
            ];
            Storage::delete('public/'.$item->avatar);
        } else if (!$request->phone_number && $request->address && $request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'address' => $request->address,
                'avatar' => $request->file('avatar')->store('upload/user_avatar','public'),
            ];
            Storage::delete('public/'.$item->avatar);
        } else if ($request->phone_number && !$request->address && $request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'avatar' => $request->file('avatar')->store('upload/user_avatar','public'),
            ];
            Storage::delete('public/'.$item->avatar);
        } else if ($request->phone_number && $request->address && !$request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];
        } else if (!$request->phone_number && !$request->address && $request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'avatar' => $request->file('avatar')->store('upload/user_avatar','public'),
            ];
            Storage::delete('public/'.$item->avatar);
        } else if ($request->phone_number && !$request->address && !$request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ];
        } else if (!$request->phone_number && $request->address && !$request->hasFile('avatar')) {
            $data = [
                'name' => $request->name,
                'address' => $request->address,
            ];
        } else {
            $data = [
                'name' => $request->name,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.user.index')->with('success', 'Profil Berhasil Diubah!');
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

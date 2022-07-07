<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.user.index');
    }

    public function listUser()
    {
        if(request()->ajax())
        {
            $queryUser = User::where('is_admin', false)->latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryUser)
                ->addColumn('profile', function (User $user) {
                    if ($user->is_mentor) {
                        return '
                            '.$user->name.' - '.$user->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$user->name.' - '.$user->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (User $user) {
                    if ($user->email_verified_at) {
                        return '<span class="status-btn success-btn">Email Terverifikasi</span>';
                    } else {
                        return '<span class="status-btn warning-btn">Email Belum Terverifikasi</span>';
                    }
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (User $user) {
                    return $user->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-user-show mx-auto" href="'.route('admin.user.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.user.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-user-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['profile', 'status', 'show', 'delete'])
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
        $item = User::findOrFail($hash->decodeHex($id));

        return view('pages.admin.user.show', [
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

    public function role($id)
    {
        $hash = new Hashids('', 10);
        $item = User::all()->where('is_admin', false)->findOrFail($hash->decodeHex($id));

        if ($item->is_mentor) {
            $data = [
                'is_mentor' => false,
            ];
        } else {
            $data = [
                'is_mentor' => true,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Role Pengguna Berhasil Diubah!');
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
        $item = User::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.user.index')->with('success', 'Pengguna Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.user.trash');
    }

    public function trashUser()
    {
        if(request()->ajax())
        {
            $queryUser = User::onlyTrashed()->where('is_admin', false)->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryUser)
                ->addColumn('profile', function (User $user) {
                    if ($user->is_mentor) {
                        return '
                            '.$user->name.' - '.$user->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$user->name.' - '.$user->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (User $user) {
                    if ($user->email_verified_at) {
                        return '<span class="status-btn success-btn">Email Terverifikasi</span>';
                    } else {
                        return '<span class="status-btn warning-btn">Email Belum Terverifikasi</span>';
                    }
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (User $user) {
                    return $user->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (User $user) {
                    return $user->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-user-restore mx-auto" href="'.route('admin.user.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.user.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-user-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['profile', 'status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = User::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.user.trash')->with('success', 'Pengguna Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = User::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->avatar);
        $item->forceDelete();

        return redirect()->route('admin.user.trash')->with('success', 'Pengguna Berhasil Dihapus Permanen!');
    }
}

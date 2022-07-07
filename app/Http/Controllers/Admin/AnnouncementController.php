<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Announcement;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AnnouncementRequest;
use App\Mail\User\Announcement as UserAnnouncement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.announcement.index');
    }

    public function listAnnouncement()
    {
        if(request()->ajax())
        {
            $queryAnnouncement = Announcement::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryAnnouncement)
                ->addColumn('created_at', function (Announcement $announcement) {
                    return $announcement->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Announcement $announcement) {
                    return $announcement->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-announcement-show mx-auto" href="'.route('admin.announcement.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-announcement-edit mx-auto" href="'.route('admin.announcement.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.announcement.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-announcement-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['show', 'edit', 'delete'])
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
        return view('pages.admin.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'file' => $request->file('file')->store('upload/announcement_file','public'),
            ];
        } else {
            $data = [
                'title' => $request->title,
                'content' => $request->content,
            ];
        }

        $item = Announcement::create($data);
        $receivers = User::where('is_admin', false)->get();

        foreach ($receivers as $receiver) {
            Notification::create([
                'receiver_users_id' => $receiver->id,
                'type' => 'dashboard.announcement.index',
                'title' => 'Pengumuman Baru',
                'subtitle' => 'perlu dilihat',
                'content' => 'Pengumuman baru telah dikirim oleh administrator website',
            ]);
            Mail::to($receiver->email)->send(new UserAnnouncement($hash, $item));
        }

        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman Berhasil Dibuat!');
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
        $item = Announcement::findOrFail($hash->decodeHex($id));

        return view('pages.admin.announcement.show', [
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
        $hash = new Hashids('', 10);
        $item = Announcement::findOrFail($hash->decodeHex($id));

        return view('pages.admin.announcement.edit', [
            'hash' => $hash,
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Announcement::findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'file' => $request->file('file')->store('upload/announcement_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'title' => $request->title,
                'content' => $request->content,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman Berhasil Diubah!');
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
        $item = Announcement::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.announcement.trash');
    }

    public function trashAnnouncement()
    {
        if(request()->ajax())
        {
            $queryAnnouncement = Announcement::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryAnnouncement)
                ->addColumn('created_at', function (Announcement $announcement) {
                    return $announcement->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Announcement $announcement) {
                    return $announcement->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Announcement $announcement) {
                    return $announcement->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-announcement-restore mx-auto" href="'.route('admin.announcement.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.announcement.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-announcement-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Announcement::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.announcement.trash')->with('success', 'Pengumuman Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Announcement::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.announcement.trash')->with('success', 'Pengumuman Berhasil Dihapus Permanen!');
    }
}

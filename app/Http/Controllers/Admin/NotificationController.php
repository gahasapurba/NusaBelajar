<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.notification.index');
    }

    public function listNotification()
    {
        if(request()->ajax())
        {
            $queryNotification = Notification::latest()->with('notification_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryNotification)
                ->addColumn('notification_receiver', function (Notification $notificaton) {
                    if ($notificaton->notification_receiver->is_mentor) {
                        return '
                            '.$notificaton->notification_receiver->name.' - '.$notificaton->notification_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$notificaton->notification_receiver->name.' - '.$notificaton->notification_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (Notification $notification) {
                    if ($notification->subtitle == 'perlu ditinjau') {
                        return '<span class="status-btn warning-btn">Perlu Ditinjau</span>';
                    } else if ($notification->subtitle == 'perlu dilihat') {
                        return '<span class="status-btn primary-btn">Perlu Dilihat</span>';
                    } else if ($notification->subtitle == 'telah diterima') {
                        return '<span class="status-btn success-btn">Telah Diterima</span>';
                    } else if ($notification->subtitle == 'telah ditolak') {
                        return '<span class="status-btn danger-btn">Telah Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Notification $notification) {
                    return $notification->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Notification $notification) {
                    return $notification->updated_at->diffForHumans();
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.notification.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-notification-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['notification_receiver', 'status', 'delete'])
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
        $item = Notification::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.notification.index')->with('success', 'Notifikasi Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.notification.trash');
    }

    public function trashNotification()
    {
        if(request()->ajax())
        {
            $queryNotification = Notification::onlyTrashed()->orderBy('deleted_at', 'desc')->with('notification_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryNotification)
                ->addColumn('notification_receiver', function (Notification $notificaton) {
                    if ($notificaton->notification_receiver->is_mentor) {
                        return '
                            '.$notificaton->notification_receiver->name.' - '.$notificaton->notification_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$notificaton->notification_receiver->name.' - '.$notificaton->notification_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (Notification $notification) {
                    if ($notification->subtitle == 'perlu ditinjau') {
                        return '<span class="status-btn warning-btn">Perlu Ditinjau</span>';
                    } else if ($notification->subtitle == 'perlu dilihat') {
                        return '<span class="status-btn primary-btn">Perlu Dilihat</span>';
                    } else if ($notification->subtitle == 'telah diterima') {
                        return '<span class="status-btn success-btn">Telah Diterima</span>';
                    } else if ($notification->subtitle == 'telah ditolak') {
                        return '<span class="status-btn danger-btn">Telah Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Notification $notification) {
                    return $notification->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Notification $notification) {
                    return $notification->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Notification $notification) {
                    return $notification->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-message-restore mx-auto" href="'.route('admin.message.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.notification.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-notification-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['notification_receiver', 'status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Notification::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.notification.trash')->with('success', 'Notifikasi Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Notification::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.notification.trash')->with('success', 'Notifikasi Berhasil Dihapus Permanen!');
    }
}

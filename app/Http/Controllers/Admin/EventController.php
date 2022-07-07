<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Event;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Mail\Mentor\Event as MentorEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.event.index');
    }

    public function listEvent()
    {
        if(request()->ajax())
        {
            $queryEvent = Event::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryEvent)
                ->addColumn('status', function (Event $event) {
                    if (!$event->is_accepted && !$event->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($event->is_accepted && !$event->is_rejected) {
                        return '<span class="status-btn success-btn">Event Disetujui</span>';
                    } else if (!$event->is_accepted && $event->is_rejected) {
                        return '<span class="status-btn danger-btn">Event Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Event $event) {
                    return $event->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Event $event) {
                    return $event->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-event-show mx-auto" href="'.route('admin.event.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-event-edit mx-auto" href="'.route('admin.event.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.event.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-event-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'show', 'edit', 'delete'])
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
        $item = Event::findOrFail($hash->decodeHex($id));

        return view('pages.admin.event.show', [
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
        $item = Event::findOrFail($hash->decodeHex($id));
        $event_categories = EventCategory::all();

        return view('pages.admin.event.edit', [
            'hash' => $hash,
            'item' => $item,
            'event_categories' => $event_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Event::findOrFail($hash->decodeHex($id));

        if ($request->google_map_link && $request->hasFile('thumbnail') && $request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'google_map_link' => $request->google_map_link,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/event_thumbnail','public'),
                'file' => $request->file('file')->store('upload/event_file','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->file);
        } else if (!$request->google_map_link && $request->hasFile('thumbnail') && $request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/event_thumbnail','public'),
                'file' => $request->file('file')->store('upload/event_file','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
            Storage::delete('public/'.$item->file);
        } else if ($request->google_map_link && !$request->hasFile('thumbnail') && $request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'google_map_link' => $request->google_map_link,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/event_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else if ($request->google_map_link && $request->hasFile('thumbnail') && !$request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'google_map_link' => $request->google_map_link,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/event_thumbnail','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
        } else if (!$request->google_map_link && !$request->hasFile('thumbnail') && $request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/event_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else if ($request->google_map_link && !$request->hasFile('thumbnail') && !$request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'google_map_link' => $request->google_map_link,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
            ];
        } else if (!$request->google_map_link && $request->hasFile('thumbnail') && !$request->hasFile('file')) {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/event_thumbnail','public'),
            ];
            Storage::delete('public/'.$item->thumbnail);
        } else {
            $data = [
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Diubah!');
    }

    public function accept(EventRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Event::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        if ($request->review) {
            $data = [
                'is_accepted' => true,
                'review' => $request->review,
            ];
        } else {
            $data = [
                'is_accepted' => true,
            ];
        }

        $item->update($data);
        $receiver = User::findOrFail($item->organizer_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.mentor.event.index',
            'title' => 'Peninjauan Event Anda',
            'subtitle' => 'telah diterima',
            'content' => 'Selamat, event anda telah diterima untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new MentorEvent($hash, $item));

        return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Diterima!');
    }
    
    public function reject(EventRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Event::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        if ($request->review) {
            $data = [
                'is_rejected' => true,
                'review' => $request->review,
            ];
        } else {
            $data = [
                'is_rejected' => true,
            ];
        }

        $item->update($data);
        $receiver = User::findOrFail($item->organizer_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.mentor.event.index',
            'title' => 'Peninjauan Event Anda',
            'subtitle' => 'telah ditolak',
            'content' => 'Maaf, event anda telah ditolak untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new MentorEvent($hash, $item));

        return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Ditolak!');
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
        $item = Event::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.event.index')->with('success', 'Event Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.event.trash');
    }

    public function trashEvent()
    {
        if(request()->ajax())
        {
            $queryEvent = Event::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryEvent)
                ->addColumn('status', function (Event $event) {
                    if (!$event->is_accepted && !$event->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($event->is_accepted && !$event->is_rejected) {
                        return '<span class="status-btn success-btn">Event Disetujui</span>';
                    } else if (!$event->is_accepted && $event->is_rejected) {
                        return '<span class="status-btn danger-btn">Event Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Event $event) {
                    return $event->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Event $event) {
                    return $event->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Event $event) {
                    return $event->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-event-restore mx-auto" href="'.route('admin.event.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.event.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-event-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Event::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.event.trash')->with('success', 'Event Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Event::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->thumbnail);
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.event.trash')->with('success', 'Event Berhasil Dihapus Permanen!');
    }
}

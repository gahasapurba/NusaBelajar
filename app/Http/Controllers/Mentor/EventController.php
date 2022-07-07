<?php

namespace App\Http\Controllers\Mentor;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Event;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest\StoreEventRequest;
use App\Http\Requests\EventRequest\UpdateEventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\Event as AdminEvent;
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
        return view('pages.dashboard.mentor.event.index');
    }

    public function listEvent()
    {
        if(request()->ajax())
        {
            $queryEvent = Event::where('organizer_users_id', Auth::user()->id)->latest();
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
                            <a class="text-info dashboard-mentor-event-show mx-auto" href="'.route('dashboard.mentor.event.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-event-edit mx-auto" href="'.route('dashboard.mentor.event.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.event.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-event-destroy">
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
        $hash = new Hashids('', 10);
        $event_categories = EventCategory::all();

        return view('pages.dashboard.mentor.event.create',[
            'hash' => $hash,
            'event_categories' => $event_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->google_map_link && $request->hasFile('file')) {
            $data = [
                'organizer_users_id' => Auth::user()->id,
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
        } else if (!$request->google_map_link && $request->hasFile('file')) {
            $data = [
                'organizer_users_id' => Auth::user()->id,
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
        } else if ($request->google_map_link && !$request->hasFile('file')) {
            $data = [
                'organizer_users_id' => Auth::user()->id,
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
        } else {
            $data = [
                'organizer_users_id' => Auth::user()->id,
                'category_event_categories_id' => $hash->decodeHex($request->category_event_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'location' => $request->location,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
                'description' => $request->description,
                'thumbnail' => $request->file('thumbnail')->store('upload/event_thumbnail','public'),
            ];
        }

        $item = Event::create($data);
        $administrators = User::where('is_admin', true)->get();
        
        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.event.index',
                'title' => 'Event Baru',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Event baru telah dikirim dan memerlukan peninjauan',
            ]);
            Mail::to($administrator->email)->send(new AdminEvent($hash, $item));
        }

        return redirect()->route('dashboard.mentor.event.index')->with('success', 'Event Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
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
        $item = Event::all()->where('organizer_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.mentor.event.show', [
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
        $item = Event::all()->where('organizer_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $event_categories = EventCategory::all();

        return view('pages.dashboard.mentor.event.edit', [
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
    public function update(UpdateEventRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Event::all()->where('organizer_users_id', Auth::user()->id)->find($hash->decodeHex($id));

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

        return redirect()->route('dashboard.mentor.event.index')->with('success', 'Event Berhasil Diubah!');
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
        $item = Event::all()->where('organizer_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.event.index')->with('success', 'Event Berhasil Dihapus!');
    }
}

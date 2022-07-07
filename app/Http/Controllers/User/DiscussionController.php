<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Discussion;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\DiscussionCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DiscussionRequest\StoreDiscussionRequest;
use App\Http\Requests\DiscussionRequest\UpdateDiscussionRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\Admin\Discussion as AdminDiscussion;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.discussion.index');
    }

    public function listDiscussion()
    {
        if(request()->ajax())
        {
            $queryDiscussion = Discussion::where('sender_users_id', Auth::user()->id)->latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussion)
                ->addColumn('status', function (Discussion $discussion) {
                    if (!$discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected && $discussion->is_featured) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Diskusi Direkomendasikan</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span>';
                    } else if (!$discussion->is_accepted && $discussion->is_rejected) {
                        return '<span class="status-btn danger-btn">Diskusi Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Discussion $discussion) {
                    return $discussion->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Discussion $discussion) {
                    return $discussion->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info dashboard-discussion-show mx-auto" href="'.route('dashboard.discussion.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-discussion-edit mx-auto" href="'.route('dashboard.discussion.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.discussion.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-discussion-destroy">
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
        $discussion_categories = DiscussionCategory::all();

        return view('pages.dashboard.discussion.create',[
            'hash' => $hash,
            'discussion_categories' => $discussion_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscussionRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'category_discussion_categories_id' => $hash->decodeHex($request->category_discussion_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/discussion_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'category_discussion_categories_id' => $hash->decodeHex($request->category_discussion_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
            ];
        }

        $item = Discussion::create($data);
        $administrators = User::where('is_admin', true)->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.discussion.index',
                'title' => 'Diskusi Baru',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Diskusi baru telah dikirim dan memerlukan peninjauan',
            ]);
            Mail::to($administrator->email)->send(new AdminDiscussion($hash, $item));
        }

        return redirect()->route('dashboard.discussion.index')->with('success', 'Diskusi Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
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
        $item = Discussion::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.discussion.show', [
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
        $item = Discussion::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $discussion_categories = DiscussionCategory::all();

        return view('pages.dashboard.discussion.edit', [
            'hash' => $hash,
            'item' => $item,
            'discussion_categories' => $discussion_categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscussionRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'category_discussion_categories_id' => $hash->decodeHex($request->category_discussion_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'file' => $request->file('file')->store('upload/discussion_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'category_discussion_categories_id' => $hash->decodeHex($request->category_discussion_categories_id),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
            ];
        }

        $item->update($data);

        return redirect()->route('dashboard.discussion.index')->with('success', 'Diskusi Berhasil Diubah!');
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
        $item = Discussion::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.discussion.index')->with('success', 'Diskusi Berhasil Dihapus!');
    }
}

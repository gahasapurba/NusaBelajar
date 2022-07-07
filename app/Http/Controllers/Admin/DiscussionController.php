<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Discussion;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\DiscussionCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DiscussionRequest;
use App\Mail\User\Discussion as UserDiscussion;
use Yajra\DataTables\Facades\DataTables;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.discussion.index');
    }

    public function listDiscussion()
    {
        if(request()->ajax())
        {
            $queryDiscussion = Discussion::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussion)
                ->addColumn('status', function (Discussion $discussion) {
                    if (!$discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected && $discussion->is_featured) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span><span class="status-btn secondary-btn">Diskusi Direkomendasikan</span>';
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
                            <a class="text-info admin-discussion-show mx-auto" href="'.route('admin.discussion.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discussion-edit mx-auto" href="'.route('admin.discussion.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discussion.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discussion-destroy">
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
        $item = Discussion::findOrFail($hash->decodeHex($id));

        return view('pages.admin.discussion.show', [
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
        $item = Discussion::findOrFail($hash->decodeHex($id));
        $discussion_categories = DiscussionCategory::all();

        return view('pages.admin.discussion.edit', [
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
    public function update(DiscussionRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::findOrFail($hash->decodeHex($id));

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

        return redirect()->route('admin.discussion.index')->with('success', 'Diskusi Berhasil Diubah!');
    }

    public function accept(DiscussionRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

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
        $receiver = User::findOrFail($item->sender_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.discussion.index',
            'title' => 'Peninjauan Diskusi Anda',
            'subtitle' => 'telah diterima',
            'content' => 'Selamat, diskusi anda telah diterima untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new UserDiscussion($hash, $item));

        return redirect()->route('admin.discussion.index')->with('success', 'Diskusi Berhasil Diterima!');
    }
    
    public function reject(DiscussionRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

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
        $receiver = User::findOrFail($item->sender_users_id);

        Notification::create([
            'receiver_users_id' => $receiver->id,
            'type' => 'dashboard.discussion.index',
            'title' => 'Peninjauan Diskusi Anda',
            'subtitle' => 'telah ditolak',
            'content' => 'Maaf, diskusi anda telah ditolak untuk ditampilkan di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new UserDiscussion($hash, $item));

        return redirect()->route('admin.discussion.index')->with('success', 'Diskusi Berhasil Ditolak!');
    }

    public function featured($id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::all()->where('is_accepted')->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

        $data = [
            'is_featured' => true,
        ];

        $item->update($data);

        return redirect()->route('admin.discussion.index')->with('success', 'Diskusi Berhasil Direkomendasikan!');
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
        $item = Discussion::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.discussion.index')->with('success', 'Diskusi Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.discussion.trash');
    }

    public function trashDiscussion()
    {
        if(request()->ajax())
        {
            $queryDiscussion = Discussion::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussion)
                ->addColumn('status', function (Discussion $discussion) {
                    if (!$discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span>';
                    } else if ($discussion->is_accepted && !$discussion->is_rejected && $discussion->is_featured) {
                        return '<span class="status-btn success-btn">Diskusi Disetujui</span><span class="status-btn secondary-btn">Diskusi Direkomendasikan</span>';
                    } else if (!$discussion->is_accepted && $discussion->is_rejected) {
                        return '<span class="status-btn danger-btn">Diskusi Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Discussion $discussion) {
                    return $discussion->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Discussion $discussion) {
                    return $discussion->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Discussion $discussion) {
                    return $discussion->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discussion-restore mx-auto" href="'.route('admin.discussion.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discussion.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discussion-kill">
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
        $item = Discussion::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.discussion.trash')->with('success', 'Diskusi Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Discussion::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.discussion.trash')->with('success', 'Diskusi Berhasil Dihapus Permanen!');
    }
}

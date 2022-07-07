<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\MessageRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\User\Message as UserMessage;
use App\Mail\Admin\Message as AdminMessage;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.message.index');
    }

    public function listMessage()
    {
        if(request()->ajax())
        {
            $queryMessage = Message::latest()->with('message_creator', 'message_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMessage)
                ->addColumn('message_creator', function (Message $message) {
                    if ($message->message_creator->is_mentor) {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('message_receiver', function (Message $message) {
                    if ($message->message_receiver->is_mentor) {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('created_at', function (Message $message) {
                    return $message->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Message $message) {
                    return $message->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-message-show mx-auto" href="'.route('admin.message.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-message-edit mx-auto" href="'.route('admin.message.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.message.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-message-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['message_creator', 'message_receiver', 'show', 'edit', 'delete'])
                ->make();
        }
    }

    public function sended()
    {
        return view('pages.admin.message.sended');
    }

    public function sendedMessage()
    {
        if(request()->ajax())
        {
            $queryMessage = Message::latest()->with('message_creator', 'message_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMessage)
                ->addColumn('message_receiver', function (Message $message) {
                    if ($message->message_receiver->is_mentor) {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('created_at', function (Message $message) {
                    return $message->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Message $message) {
                    return $message->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-message-show mx-auto" href="'.route('admin.message.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-message-edit mx-auto" href="'.route('admin.message.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.message.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-message-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['message_receiver', 'show', 'edit', 'delete'])
                ->make();
        }
    }
    
    public function received()
    {
        return view('pages.admin.message.received');
    }

    public function receivedMessage()
    {
        if(request()->ajax())
        {
            $queryMessage = Message::latest()->with('message_creator', 'message_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMessage)
                ->addColumn('message_creator', function (Message $message) {
                    if ($message->message_creator->is_mentor) {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('created_at', function (Message $message) {
                    return $message->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Message $message) {
                    return $message->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-message-show mx-auto" href="'.route('admin.message.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-message-edit mx-auto" href="'.route('admin.message.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.message.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-message-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['message_creator', 'show', 'edit', 'delete'])
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
        $users = User::all()->whereNotIn('id', Auth::user()->id);

        return view('pages.admin.message.create',[
            'hash' => $hash,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->hasFile('file')) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'receiver_users_id' => $hash->decodeHex($request->receiver_users_id),
                'message' => $request->message,
                'file' => $request->file('file')->store('upload/message_file','public'),
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'receiver_users_id' => $hash->decodeHex($request->receiver_users_id),
                'message' => $request->message,
            ];
        }

        $item = Message::create($data);
        $receiver = User::findOrFail($item->receiver_users_id);

        if ($receiver->is_admin) {
            Notification::create([
                'receiver_users_id' => $receiver->id,
                'type' => 'admin.message.received',
                'title' => 'Pesan Baru',
                'subtitle' => 'perlu dilihat',
                'content' => 'Pesan baru telah dikirim oleh {$item->message_creator->name} kepada anda',
            ]);
            Mail::to($receiver->email)->send(new AdminMessage($hash, $item));
        } else {
            Notification::create([
                'receiver_users_id' => $receiver->id,
                'type' => 'dashboard.message.received',
                'title' => 'Pesan Baru',
                'subtitle' => 'perlu dilihat',
                'content' => 'Pesan baru telah dikirim oleh {$item->message_creator->name} kepada anda',
            ]);
            Mail::to($receiver->email)->send(new UserMessage($hash, $item));
        }

        return redirect()->route('admin.message.sended')->with('success', 'Pesan Berhasil Dibuat!');
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
        $item = Message::findOrFail($hash->decodeHex($id));

        return view('pages.admin.message.show', [
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
        $item = Message::findOrFail($hash->decodeHex($id));

        return view('pages.admin.message.edit', [
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
    public function update(MessageRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Message::findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'message' => $request->message,
                'file' => $request->file('file')->store('upload/message_file','public'),
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'message' => $request->message,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.message.sended')->with('success', 'Pesan Berhasil Diubah!');
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
        $item = Message::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.message.sended')->with('success', 'Pesan Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.message.trash');
    }

    public function trashMessage()
    {
        if(request()->ajax())
        {
            $queryMessage = Message::onlyTrashed()->orderBy('deleted_at', 'desc')->with('message_creator', 'message_receiver');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMessage)
                ->addColumn('message_creator', function (Message $message) {
                    if ($message->message_creator->is_mentor) {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_creator->name.' - '.$message->message_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('message_receiver', function (Message $message) {
                    if ($message->message_receiver->is_mentor) {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$message->message_receiver->name.' - '.$message->message_receiver->email.' (User)
                        ';
                    }
                })
                ->addColumn('created_at', function (Message $message) {
                    return $message->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Message $message) {
                    return $message->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Message $message) {
                    return $message->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
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
                            <form class="mx-auto" method="POST" action="'.route('admin.message.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-message-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['message_creator', 'message_receiver', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Message::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.message.trash')->with('success', 'Pesan Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Message::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.message.trash')->with('success', 'Pesan Berhasil Dihapus Permanen!');
    }
}

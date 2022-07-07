<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MentorVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\MentorVerificationRequest;
use App\Mail\User\MentorVerification as UserMentorVerification;

class MentorVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.mentor_verification.index');
    }

    public function listMentorVerification()
    {
        if(request()->ajax())
        {
            $queryMentorVerification = MentorVerification::latest()->with('mentor_verification_creator');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMentorVerification)
                ->addColumn('mentor_verification_creator', function (MentorVerification $mentor_verification) {
                    if ($mentor_verification->mentor_verification_creator->is_mentor) {
                        return '
                            '.$mentor_verification->mentor_verification_creator->name.' - '.$mentor_verification->mentor_verification_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$mentor_verification->mentor_verification_creator->name.' - '.$mentor_verification->mentor_verification_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (MentorVerification $mentor_verification) {
                    if (!$mentor_verification->is_accepted && !$mentor_verification->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($mentor_verification->is_accepted && !$mentor_verification->is_rejected) {
                        return '<span class="status-btn success-btn">Verifikasi Mentor Disetujui</span>';
                    } else if (!$mentor_verification->is_accepted && $mentor_verification->is_rejected) {
                        return '<span class="status-btn danger-btn">Verifikasi Mentor Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (MentorVerification $mentor_verification) {
                    return $mentor_verification->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (MentorVerification $mentor_verification) {
                    return $mentor_verification->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-mentor-verification-show mx-auto" href="'.route('admin.mentor.verification.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-mentor-verification-edit mx-auto" href="'.route('admin.mentor.verification.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.mentor.verification.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-mentor-verification-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['mentor_verification_creator', 'status', 'show', 'edit', 'delete'])
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
        $item = MentorVerification::findOrFail($hash->decodeHex($id));

        return view('pages.admin.mentor_verification.show', [
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
        $item = MentorVerification::findOrFail($hash->decodeHex($id));

        return view('pages.admin.mentor_verification.edit', [
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
    public function update(MentorVerificationRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::findOrFail($hash->decodeHex($id));

        if ($request->facebook_profile_link && $request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'instagram_profile_link' => $request->instagram_profile_link,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if (!$request->facebook_profile_link && $request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'instagram_profile_link' => $request->instagram_profile_link,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && !$request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && $request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'instagram_profile_link' => $request->instagram_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if (!$request->facebook_profile_link && !$request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && !$request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if (!$request->facebook_profile_link && $request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'instagram_profile_link' => $request->instagram_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else {
            $data = [
                'profile_summary' => $request->profile_summary,
                'whatsapp_number' => $request->whatsapp_number,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Diubah!');
    }

    public function accept(MentorVerificationRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

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
            'type' => 'dashboard.mentor.verification.index',
            'title' => 'Peninjauan Verifikasi Mentor Anda',
            'subtitle' => 'telah diterima',
            'content' => 'Selamat, verifikasi mentor anda telah diterima dan anda telah resmi menjadi mentor di website NusaBelajar',
        ]);
        Mail::to($receiver->email)->send(new UserMentorVerification($hash, $item));

        return redirect()->route('admin.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Diterima!');
    }
    
    public function reject(MentorVerificationRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::all()->where('is_accepted', false)->where('is_rejected', false)->findOrFail($hash->decodeHex($id));

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
            'type' => 'dashboard.mentor.verification.index',
            'title' => 'Peninjauan Verifikasi Mentor Anda',
            'subtitle' => 'telah ditolak',
            'content' => 'Maaf, verifikasi mentor anda telah ditolak',
        ]);
        Mail::to($receiver->email)->send(new UserMentorVerification($hash, $item));

        return redirect()->route('admin.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Ditolak!');
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
        $item = MentorVerification::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.mentor_verification.trash');
    }

    public function trashMentorVerification()
    {
        if(request()->ajax())
        {
            $queryMentorVerification = MentorVerification::onlyTrashed()->orderBy('deleted_at', 'desc')->with('mentor_verification_creator');
            $hash = new Hashids('', 10);

            return DataTables::of($queryMentorVerification)
                ->addColumn('mentor_verification_creator', function (MentorVerification $mentor_verification) {
                    if ($mentor_verification->mentor_verification_creator->is_mentor) {
                        return '
                            '.$mentor_verification->mentor_verification_creator->name.' - '.$mentor_verification->mentor_verification_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$mentor_verification->mentor_verification_creator->name.' - '.$mentor_verification->mentor_verification_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (MentorVerification $mentor_verification) {
                    if (!$mentor_verification->is_accepted && !$mentor_verification->is_rejected) {
                        return '<span class="status-btn warning-btn">Proses Peninjauan</span>';
                    } else if ($mentor_verification->is_accepted && !$mentor_verification->is_rejected) {
                        return '<span class="status-btn success-btn">Verifikasi Mentor Disetujui</span>';
                    } else if (!$mentor_verification->is_accepted && $mentor_verification->is_rejected) {
                        return '<span class="status-btn danger-btn">Verifikasi Mentor Ditolak</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (MentorVerification $mentor_verification) {
                    return $mentor_verification->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (MentorVerification $mentor_verification) {
                    return $mentor_verification->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (MentorVerification $mentor_verification) {
                    return $mentor_verification->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-mentor-verification-restore mx-auto" href="'.route('admin.mentor.verification.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.mentor.verification.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-mentor-verification-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['mentor_verification_creator', 'status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.mentor.verification.trash')->with('success', 'Verifikasi Mentor Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->id_card);
        Storage::delete('public/'.$item->selfie_with_id_card);
        Storage::delete('public/'.$item->resume);
        $item->forceDelete();

        return redirect()->route('admin.mentor.verification.trash')->with('success', 'Verifikasi Mentor Berhasil Dihapus Permanen!');
    }
}

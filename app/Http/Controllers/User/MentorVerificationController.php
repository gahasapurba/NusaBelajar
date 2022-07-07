<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MentorVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\MentorVerificationRequest\StoreMentorVerificationRequest;
use App\Http\Requests\MentorVerificationRequest\UpdateMentorVerificationRequest;
use App\Mail\Admin\MentorVerification as AdminMentorVerification;

class MentorVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.mentor_verification.index');
    }

    public function listMentorVerification()
    {
        if(request()->ajax())
        {
            $queryMentorVerification = MentorVerification::where('sender_users_id', Auth::user()->id)->latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryMentorVerification)
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
                            <a class="text-info dashboard-mentor-verification-show mx-auto" href="'.route('dashboard.mentor.verification.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning dashboard-mentor-verification-edit mx-auto" href="'.route('dashboard.mentor.verification.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.mentor.verification.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-mentor-verification-destroy">
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
        return view('pages.dashboard.mentor_verification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMentorVerificationRequest $request)
    {
        $hash = new Hashids('', 10);

        if ($request->facebook_profile_link && $request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
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
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'instagram_profile_link' => $request->instagram_profile_link,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && !$request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && $request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'instagram_profile_link' => $request->instagram_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if (!$request->facebook_profile_link && !$request->instagram_profile_link && $request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'linkedin_profile_link' => $request->linkedin_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if ($request->facebook_profile_link && !$request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'facebook_profile_link' => $request->facebook_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else if (!$request->facebook_profile_link && $request->instagram_profile_link && !$request->linkedin_profile_link) {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'instagram_profile_link' => $request->instagram_profile_link,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        } else {
            $data = [
                'sender_users_id' => Auth::user()->id,
                'profile_summary' => $request->profile_summary,
                'id_card' => $request->file('id_card')->store('upload/mentor_verification_id_card','public'),
                'selfie_with_id_card' => $request->file('selfie_with_id_card')->store('upload/mentor_verification_selfie_with_id_card','public'),
                'resume' => $request->file('resume')->store('upload/mentor_verification_resume','public'),
                'whatsapp_number' => $request->whatsapp_number,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'bank_name' => $request->bank_name,
            ];
        }

        $item = MentorVerification::create($data);
        $administrators = User::where('is_admin', true)->get();

        foreach ($administrators as $administrator) {
            Notification::create([
                'receiver_users_id' => $administrator->id,
                'type' => 'admin.mentor.verification.index',
                'title' => 'Verifikasi Mentor Baru',
                'subtitle' => 'perlu ditinjau',
                'content' => 'Verifikasi mentor baru telah dikirim dan memerlukan peninjauan',
            ]);
            Mail::to($administrator->email)->send(new AdminMentorVerification($hash, $item));
        }

        return redirect()->route('dashboard.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
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
        $item = MentorVerification::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.mentor_verification.show', [
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
        $item = MentorVerification::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));

        return view('pages.dashboard.mentor_verification.edit', [
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
    public function update(UpdateMentorVerificationRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = MentorVerification::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));

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

        return redirect()->route('dashboard.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Diubah!');
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
        $item = MentorVerification::all()->where('sender_users_id', Auth::user()->id)->find($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('dashboard.mentor.verification.index')->with('success', 'Verifikasi Mentor Berhasil Dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\EmailSubscription;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailSubscriptionRequest;
use Yajra\DataTables\Facades\DataTables;

class EmailSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.email_subscription.index');
    }

    public function listEmailSubscription()
    {
        if(request()->ajax())
        {
            $queryEmailSubscription = EmailSubscription::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryEmailSubscription)
                ->addColumn('created_at', function (EmailSubscription $email_subscription) {
                    return $email_subscription->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (EmailSubscription $email_subscription) {
                    return $email_subscription->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-email-subscription-show mx-auto" href="'.route('admin.email.subscription.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-email-subscription-edit mx-auto" href="'.route('admin.email.subscription.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.email.subscription.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-email-subscription-destroy">
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
        $item = EmailSubscription::findOrFail($hash->decodeHex($id));

        return view('pages.admin.email_subscription.show', [
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
        $item = EmailSubscription::findOrFail($hash->decodeHex($id));

        return view('pages.admin.email_subscription.edit', [
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
    public function update(EmailSubscriptionRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = EmailSubscription::findOrFail($hash->decodeHex($id));

        $data = [
            'email' => $request->email,
        ];

        $item->update($data);

        return redirect()->route('admin.email.subscription.index')->with('success', 'Email Berlangganan Berhasil Diubah!');
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
        $item = EmailSubscription::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.email.subscription.index')->with('success', 'Email Berlangganan Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.email_subscription.trash');
    }

    public function trashEmailSubscription()
    {
        if(request()->ajax())
        {
            $queryEmailSubscription = EmailSubscription::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryEmailSubscription)
                ->addColumn('created_at', function (EmailSubscription $email_subscription) {
                    return $email_subscription->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (EmailSubscription $email_subscription) {
                    return $email_subscription->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (EmailSubscription $email_subscription) {
                    return $email_subscription->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-email-subscription-restore mx-auto" href="'.route('admin.email.subscription.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.email.subscription.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-email-subscription-kill">
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
        $item = EmailSubscription::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.email.subscription.trash')->with('success', 'Email Berlangganan Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = EmailSubscription::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.email.subscription.trash')->with('success', 'Email Berlangganan Berhasil Dihapus Permanen!');
    }
}

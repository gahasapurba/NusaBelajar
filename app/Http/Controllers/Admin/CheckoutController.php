<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.checkout.index');
    }

    public function listCheckout()
    {
        if(request()->ajax())
        {
            $queryCheckout = Checkout::latest()->with('checkout_creator');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCheckout)
                ->addColumn('checkout_creator', function (Checkout $checkout) {
                    if ($checkout->checkout_creator->is_mentor) {
                        return '
                            '.$checkout->checkout_creator->name.' - '.$checkout->checkout_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$checkout->checkout_creator->name.' - '.$checkout->checkout_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (Checkout $checkout) {
                    if ($checkout == 'waiting') {
                        return '<span class="status-btn warning-btn">Proses Pembayaran</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Checkout $checkout) {
                    return $checkout->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Checkout $checkout) {
                    return $checkout->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-checkout-show mx-auto" href="'.route('admin.checkout.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.checkout.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-checkout-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['checkout_creator', 'status', 'show', 'delete'])
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
        $item = Checkout::findOrFail($hash->decodeHex($id));

        return view('pages.admin.checkout.show', [
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
        $item = Checkout::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.article.checkout.index')->with('success', 'Transaksi Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.checkout.trash');
    }

    public function trashCheckout()
    {
        if(request()->ajax())
        {
            $queryCheckout = Checkout::onlyTrashed()->orderBy('deleted_at', 'desc')->with('checkout_creator');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCheckout)
                ->addColumn('checkout_creator', function (Checkout $checkout) {
                    if ($checkout->checkout_creator->is_mentor) {
                        return '
                            '.$checkout->checkout_creator->name.' - '.$checkout->checkout_creator->email.' (Mentor)
                        ';
                    } else {
                        return '
                            '.$checkout->checkout_creator->name.' - '.$checkout->checkout_creator->email.' (User)
                        ';
                    }
                })
                ->addColumn('status', function (Checkout $checkout) {
                    if ($checkout == 'waiting') {
                        return '<span class="status-btn warning-btn">Proses Pembayaran</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('created_at', function (Checkout $checkout) {
                    return $checkout->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Checkout $checkout) {
                    return $checkout->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Checkout $checkout) {
                    return $checkout->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-checkout-restore mx-auto" href="'.route('admin.checkout.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.checkout.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-checkout-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['checkout_creator', 'status', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Checkout::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.article.checkout.trash')->with('success', 'Transaksi Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Checkout::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.article.checkout.trash')->with('success', 'Transaksi Berhasil Dihapus Permanen!');
    }
}

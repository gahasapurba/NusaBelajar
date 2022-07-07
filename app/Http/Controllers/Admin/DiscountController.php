<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DiscountRequest\StoreDiscountRequest;
use App\Http\Requests\DiscountRequest\UpdateDiscountRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\User\Discount as UserDiscount;
use App\Models\EmailSubscription;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.discount.index');
    }

    public function listDiscount()
    {
        if(request()->ajax())
        {
            $queryDiscount = Discount::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscount)
                ->addColumn('created_at', function (Discount $discount) {
                    return $discount->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Discount $discount) {
                    return $discount->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-discount-show mx-auto" href="'.route('admin.discount.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discount-edit mx-auto" href="'.route('admin.discount.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discount.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discount-destroy">
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
        return view('pages.admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscountRequest $request)
    {
        $hash = new Hashids('', 10);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'code' => $request->code,
            'percentage' => $request->percentage,
        ];

        $item = Discount::create($data);
        $receivers = EmailSubscription::all();

        foreach ($receivers as $receiver) {
            Mail::to($receiver->email)->send(new UserDiscount($hash, $item));
        }

        return redirect()->route('admin.discount.index')->with('success', 'Promo Berhasil Dibuat!');
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
        $item = Discount::findOrFail($hash->decodeHex($id));

        return view('pages.admin.discount.show', [
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
        $item = Discount::findOrFail($hash->decodeHex($id));

        return view('pages.admin.discount.edit', [
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
    public function update(UpdateDiscountRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Discount::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'code' => $request->code,
            'percentage' => $request->percentage,
        ];

        $item->update($data);

        return redirect()->route('admin.discount.index')->with('success', 'Promo Berhasil Diubah!');
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
        $item = Discount::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.discount.index')->with('success', 'Promo Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.discount.trash');
    }

    public function trashDiscount()
    {
        if(request()->ajax())
        {
            $queryDiscount = Discount::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscount)
                ->addColumn('created_at', function (Discount $discount) {
                    return $discount->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (Discount $discount) {
                    return $discount->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (Discount $discount) {
                    return $discount->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discount-restore mx-auto" href="'.route('admin.discount.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discount.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discount-kill">
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
        $item = Discount::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.discount.trash')->with('success', 'Promo Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Discount::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.discount.trash')->with('success', 'Promo Berhasil Dihapus Permanen!');
    }
}

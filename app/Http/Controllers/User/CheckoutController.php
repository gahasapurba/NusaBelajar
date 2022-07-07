<?php

namespace App\Http\Controllers\User;

use Hashids\Hashids;
use Midtrans\Config;
use App\Models\Checkout;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.checkout.index');
    }

    public function listCheckout()
    {
        if(request()->ajax())
        {
            $queryCheckout = Checkout::where('buyer_users_id', Auth::user()->id)->latest()->with('checkout_creator');
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
                            <a class="text-info dashboard-checkout-show mx-auto" href="'.route('dashboard.checkout.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('dashboard.checkout.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger dashboard-checkout-destroy">
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
        $hash = new Hashids('', 10);

        $data = [
            'buyer_users_id' => Auth::user()->id,
            'course_courses_id' => $hash->decodeHex($request->course_courses_id),
        ];

        // $item= Checkout::create($data);
        // $this->getSnapRedirect($item);
        // $item = Discussion::findOrFail($data['discussion_discussions_id']);

        // if ($item->sender_users_id != Auth::user()->id) {
        //     Notification::create([
        //         'receiver_users_id' => $item->sender_users_id,
        //         'type' => 'discussion.index',
        //         'title' => 'Jawaban Baru Pada Diskusi Anda',
        //         'subtitle' => 'perlu dilihat',
        //         'content' => 'Jawaban baru telah dikirim oleh seseorang pada diskusi anda yang berjudul "{$item->title}"',
        //     ]);
        //     Mail::to($item->discussion_creator->email)->send(new UserDiscussionAnswer($item));
        // }

        // $administrators = User::where('is_admin')->get();

        // foreach ($administrators as $administrator) {
        //     Notification::create([
        //         'receiver_users_id' => $administrator->id,
        //         'type' => 'discussion.index',
        //         'title' => 'Jawaban Baru Pada Diskusi',
        //         'subtitle' => 'perlu dilihat',
        //         'content' => 'Jawaban baru telah dikirim oleh seseorang pada sebuah diskusi yang berjudul "{$item->title}"',
        //     ]);
        //     Mail::to($administrator->email)->send(new AdminDiscussionAnswer($item));
        // }

        // return redirect()->back()->with('success', 'Jawaban Diskusi Berhasil Dibuat!');

        // return redirect()->route('dashboard.article.index')->with('success', 'Artikel Berhasil Dibuat. Silahkan Tunggu Peninjauan Oleh Administrator');
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
        $item = Checkout::all()->where('buyer_users_id', Auth::user()->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.checkout.show', [
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
        //
    }

    public function getSnapRedirect($item)
    {
        $hash = new Hashids('', 10);
        $order_id = $hash->encodeHex($item->id).'-'.Str::random(5);
        $price = $item->checkout_paid_course->price;
        $item->midtrans_booking_code = $order_id;
        
        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $price,
        ];
        $item_details[] = [
            'id' => $order_id,
            'price' => $price,
            'quantity' => 1,
            'name' => "Pembayaran Untuk Kelas '{$item->checkout_paid_course->title}' di NusaBelajar",
        ];
        $userData = [
            'first_name' => $item->checkout_creator->name,
            'last_name' => "",
            'address' => $item->checkout_creator->address,
            'city' => "",
            'postal_code' => "",
            'phone' => $item->checkout_creator->phone_number,
            'country_code' => "IDN",
        ];
        $customer_details = [
            'first_name' => $item->checkout_creator->name,
            'last_name' => "",
            'email' => $item->checkout_creator->email,
            'phone' => $item->checkout_creator->phone_number,
            'billing_address' => $userData,
            'shipping_address' => $userData,
        ];

        $midtrans_params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];
    }
}

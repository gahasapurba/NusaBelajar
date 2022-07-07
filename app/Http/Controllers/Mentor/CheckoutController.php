<?php

namespace App\Http\Controllers\Mentor;

use Hashids\Hashids;
use App\Models\Course;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        return view('pages.dashboard.mentor.checkout.index');
    }

    public function listCheckout()
    {
        if(request()->ajax())
        {
            $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
            $queryCheckout = Checkout::where('course_courses_id', $mentored_course->id)->latest()->with('checkout_creator');
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
                            <a class="text-info dashboard-mentor-checkout-show mx-auto" href="'.route('dashboard.mentor.checkout.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['checkout_creator', 'status', 'show'])
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
        $mentored_course = Course::all()->where('mentor_users_id', Auth::user()->id);
        $item = Checkout::all()->where('course_courses_id', $mentored_course->id)->findOrFail($hash->decodeHex($id));

        return view('pages.dashboard.mentor.checkout.show', [
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
}

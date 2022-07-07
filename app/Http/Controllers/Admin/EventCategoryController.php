<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\EventCategoryRequest;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.event_category.index');
    }

    public function listEventCategory()
    {
        if(request()->ajax())
        {
            $queryEventCategory = EventCategory::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryEventCategory)
                ->addColumn('created_at', function (EventCategory $event_category) {
                    return $event_category->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (EventCategory $event_category) {
                    return $event_category->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-event-category-show mx-auto" href="'.route('admin.event.category.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-event-category-edit mx-auto" href="'.route('admin.event.category.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.event.category.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-event-category-destroy">
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
        return view('pages.admin.event_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventCategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        EventCategory::create($data);

        return redirect()->route('admin.event.category.index')->with('success', 'Kategori Event Berhasil Dibuat!');
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
        $item = EventCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.event_category.show', [
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
        $item = EventCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.event_category.edit', [
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
    public function update(EventCategoryRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = EventCategory::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $item->update($data);

        return redirect()->route('admin.event.category.index')->with('success', 'Kategori Event Berhasil Diubah!');
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
        $item = EventCategory::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.event.category.index')->with('success', 'Kategori Event Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.event_category.trash');
    }

    public function trashEventCategory()
    {
        if(request()->ajax())
        {
            $queryEventCategory = EventCategory::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryEventCategory)
                ->addColumn('created_at', function (EventCategory $event_category) {
                    return $event_category->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (EventCategory $event_category) {
                    return $event_category->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (EventCategory $event_category) {
                    return $event_category->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-event-category-restore mx-auto" href="'.route('admin.event.category.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.event.category.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-event-category-kill">
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
        $item = EventCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.event.category.trash')->with('success', 'Kategori Event Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = EventCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.event.category.trash')->with('success', 'Kategori Event Berhasil Dihapus Permanen!');
    }
}

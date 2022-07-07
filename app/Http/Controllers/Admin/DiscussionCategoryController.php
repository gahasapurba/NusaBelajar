<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DiscussionCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DiscussionCategoryRequest;

class DiscussionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.discussion_category.index');
    }

    public function listDiscussionCategory()
    {
        if(request()->ajax())
        {
            $queryDiscussionCategory = DiscussionCategory::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussionCategory)
                ->addColumn('created_at', function (DiscussionCategory $discussion_category) {
                    return $discussion_category->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (DiscussionCategory $discussion_category) {
                    return $discussion_category->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-discussion-category-show mx-auto" href="'.route('admin.discussion.category.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discussion-category-edit mx-auto" href="'.route('admin.discussion.category.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discussion.category.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discussion-category-destroy">
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
        return view('pages.admin.discussion_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscussionCategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        DiscussionCategory::create($data);

        return redirect()->route('admin.discussion.category.index')->with('success', 'Kategori Diskusi Berhasil Dibuat!');
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
        $item = DiscussionCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.discussion_category.show', [
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
        $item = DiscussionCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.discussion_category.edit', [
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
    public function update(DiscussionCategoryRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = DiscussionCategory::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $item->update($data);

        return redirect()->route('admin.discussion.category.index')->with('success', 'Kategori Diskusi Berhasil Diubah!');
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
        $item = DiscussionCategory::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.discussion.category.index')->with('success', 'Kategori Diskusi Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.discussion_category.trash');
    }

    public function trashDiscussionCategory()
    {
        if(request()->ajax())
        {
            $queryDiscussionCategory = DiscussionCategory::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryDiscussionCategory)
                ->addColumn('created_at', function (DiscussionCategory $discussion_category) {
                    return $discussion_category->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (DiscussionCategory $discussion_category) {
                    return $discussion_category->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (DiscussionCategory $discussion_category) {
                    return $discussion_category->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-discussion-category-restore mx-auto" href="'.route('admin.discussion.category.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.discussion.category.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-discussion-category-kill">
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
        $item = DiscussionCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.discussion.category.trash')->with('success', 'Kategori Diskusi Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = DiscussionCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.discussion.category.trash')->with('success', 'Kategori Diskusi Berhasil Dihapus Permanen!');
    }
}

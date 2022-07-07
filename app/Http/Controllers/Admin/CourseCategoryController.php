<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseCategoryRequest;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.course_category.index');
    }

    public function listCourseCategory()
    {
        if(request()->ajax())
        {
            $queryCourseCategory = CourseCategory::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseCategory)
                ->addColumn('created_at', function (CourseCategory $course_category) {
                    return $course_category->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseCategory $course_category) {
                    return $course_category->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-course-category-show mx-auto" href="'.route('admin.course.category.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-category-edit mx-auto" href="'.route('admin.course.category.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.category.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-category-destroy">
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
        return view('pages.admin.course_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCategoryRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        CourseCategory::create($data);

        return redirect()->route('admin.course.category.index')->with('success', 'Kategori Kelas Berhasil Dibuat!');
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
        $item = CourseCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_category.show', [
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
        $item = CourseCategory::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_category.edit', [
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
    public function update(CourseCategoryRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = CourseCategory::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        $item->update($data);

        return redirect()->route('admin.course.category.index')->with('success', 'Kategori Kelas Berhasil Diubah!');
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
        $item = CourseCategory::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.course.category.index')->with('success', 'Kategori Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course_category.trash');
    }

    public function trashCourseCategory()
    {
        if(request()->ajax())
        {
            $queryCourseCategory = CourseCategory::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseCategory)
                ->addColumn('created_at', function (CourseCategory $course_category) {
                    return $course_category->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (CourseCategory $course_category) {
                    return $course_category->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (CourseCategory $course_category) {
                    return $course_category->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-category-restore mx-auto" href="'.route('admin.course.category.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.category.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-category-kill">
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
        $item = CourseCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.category.trash')->with('success', 'Kategori Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseCategory::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.course.category.trash')->with('success', 'Kategori Kelas Berhasil Dihapus Permanen!');
    }
}

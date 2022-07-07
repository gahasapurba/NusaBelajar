<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CourseMaterialRequest;

class CourseMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.course_material.index');
    }

    public function listCourseMaterial()
    {
        if(request()->ajax())
        {
            $queryCourseMaterial = CourseMaterial::latest()->with('course_material_course_sub_topic.course_sub_topic_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseMaterial)
                ->addColumn('course_sub_topic_course', function (CourseMaterial $course_material) {
                    return $course_material->course_sub_topic_course->title;
                })
                ->addColumn('created_at', function (CourseMaterial $course_material) {
                    return $course_material->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (CourseMaterial $course_material) {
                    return $course_material->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-course-material-show mx-auto" href="'.route('admin.course.material.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('edit', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-material-edit mx-auto" href="'.route('admin.course.material.edit', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-cog"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.material.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-material-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_sub_topic_course', 'show', 'edit', 'delete'])
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
        $item = CourseMaterial::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_material.show', [
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
        $item = CourseMaterial::findOrFail($hash->decodeHex($id));

        return view('pages.admin.course_material.edit', [
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
    public function update(CourseMaterialRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = CourseMaterial::findOrFail($hash->decodeHex($id));

        if ($request->hasFile('file')) {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'file' => $request->file('file')->store('upload/course_material_file','public'),
                'estimated_time' => $request->estimated_time,
            ];
            Storage::delete('public/'.$item->file);
        } else {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'youtube_video_link' => $request->youtube_video_link,
                'estimated_time' => $request->estimated_time,
            ];
        }

        $item->update($data);

        return redirect()->route('admin.course.material.index')->with('success', 'Materi Kelas Berhasil Diubah!');
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
        $item = CourseMaterial::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.course.material.index')->with('success', 'Materi Kelas Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.course_material.trash');
    }

    public function trashCourseMaterial()
    {
        if(request()->ajax())
        {
            $queryCourseMaterial = CourseMaterial::onlyTrashed()->orderBy('deleted_at', 'desc')->with('course_material_course_sub_topic.course_sub_topic_course');
            $hash = new Hashids('', 10);

            return DataTables::of($queryCourseMaterial)
                ->addColumn('course_sub_topic_course', function (CourseMaterial $course_material) {
                    return $course_material->course_sub_topic_course->title;
                })
                ->addColumn('created_at', function (CourseMaterial $course_material) {
                    return $course_material->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('updated_at', function (CourseMaterial $course_material) {
                    return $course_material->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('deleted_at', function (CourseMaterial $course_material) {
                    return $course_material->deleted_at->isoFormat('dddd, D MMMM Y, HH:mm:ss');
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-warning admin-course-material-restore mx-auto" href="'.route('admin.course.material.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.course.material.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-course-material-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['course_sub_topic_course', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseMaterial::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.course.material.trash')->with('success', 'Materi Kelas Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = CourseMaterial::onlyTrashed()->findOrFail($hash->decodeHex($id));
        Storage::delete('public/'.$item->file);
        $item->forceDelete();

        return redirect()->route('admin.course.material.trash')->with('success', 'Materi Kelas Berhasil Dihapus Permanen!');
    }
}

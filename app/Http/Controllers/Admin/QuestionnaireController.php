<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use Yajra\DataTables\Facades\DataTables;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.questionnaire.index');
    }

    public function listQuestionnaire()
    {
        if(request()->ajax())
        {
            $queryQuestionnaire = Questionnaire::latest();
            $hash = new Hashids('', 10);

            return DataTables::of($queryQuestionnaire)
                ->addColumn('questionnaire_creator', function (Questionnaire $questionnaire) {
                    return '
                        '.$questionnaire->name.' - '.$questionnaire->email.'
                    ';
                })
                ->addColumn('created_at', function (Questionnaire $questionnaire) {
                    return $questionnaire->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Questionnaire $questionnaire) {
                    return $questionnaire->updated_at->diffForHumans();
                })
                ->addColumn('show', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-questionnaire-show mx-auto" href="'.route('admin.questionnaire.show', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-eye"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('delete', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.questionnaire.destroy', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-questionnaire-destroy">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['questionnaire_creator', 'show', 'delete'])
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
        $item = Questionnaire::findOrFail($hash->decodeHex($id));

        return view('pages.admin.questionnaire.show', [
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
        $item = Questionnaire::findOrFail($hash->decodeHex($id));

        return view('pages.admin.questionnaire.edit', [
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
    public function update(QuestionnaireRequest $request, $id)
    {
        $hash = new Hashids('', 10);
        $item = Questionnaire::findOrFail($hash->decodeHex($id));

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'answer1' => $request->answer1,
            'answer2' => $request->answer2,
            'answer3' => $request->answer3,
            'answer4' => $request->answer4,
            'testimonial' => $request->testimonial,
        ];

        $item->update($data);

        return redirect()->route('admin.questionnaire.index')->with('success', 'Kuesioner Berhasil Diubah!');
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
        $item = Questionnaire::findOrFail($hash->decodeHex($id));
        $item->delete();

        return redirect()->route('admin.questionnaire.index')->with('success', 'Kuesioner Berhasil Dihapus!');
    }

    public function trash()
    {
        return view('pages.admin.questionnaire.trash');
    }

    public function trashQuestionnaire()
    {
        if(request()->ajax())
        {
            $queryQuestionnaire = Questionnaire::onlyTrashed()->orderBy('deleted_at', 'desc');
            $hash = new Hashids('', 10);

            return DataTables::of($queryQuestionnaire)
                ->addColumn('questionnaire_creator', function (Questionnaire $questionnaire) {
                    return '
                        '.$questionnaire->name.' - '.$questionnaire->email.'
                    ';
                })
                ->addColumn('created_at', function (Questionnaire $questionnaire) {
                    return $questionnaire->created_at->diffForHumans();
                })
                ->addColumn('updated_at', function (Questionnaire $questionnaire) {
                    return $questionnaire->updated_at->diffForHumans();
                })
                ->addColumn('restore', function($item) use($hash) {
                    return '
                        <div class="action">
                            <a class="text-info admin-questionnaire-restore mx-auto" href="'.route('admin.questionnaire.restore', $hash->encodeHex($item->id)).'">
                                <i class="lni lni-spinner-arrow"></i>
                            </a>
                        </div>
                    ';
                })
                ->addColumn('kill', function($item) use($hash) {
                    return '
                        <div class="action">
                            <form class="mx-auto" method="POST" action="'.route('admin.questionnaire.kill', $hash->encodeHex($item->id)).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="text-danger admin-questionnaire-kill">
                                    <i class="lni lni-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['questionnaire_creator', 'restore', 'kill'])
                ->make();
        }
    }

    public function restore($id)
    {
        $hash = new Hashids('', 10);
        $item = Questionnaire::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->restore();

        return redirect()->route('admin.questionnaire.trash')->with('success', 'Kuesioner Berhasil Direstore!');
    }
    
    public function kill($id)
    {
        $hash = new Hashids('', 10);
        $item = Questionnaire::onlyTrashed()->findOrFail($hash->decodeHex($id));
        $item->forceDelete();

        return redirect()->route('admin.questionnaire.trash')->with('success', 'Kuesioner Berhasil Dihapus Permanen!');
    }
}

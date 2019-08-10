<?php

namespace App\Http\Controllers;

use App\QualityOfAgriculture;
use Illuminate\Http\Request;

use Yajra\DataTables\Html\Builder;
use DataTables;
use Validator;
use Laratrust;

use App\Quality;
use App\Agriculture;

class QualityOfAgricultureController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-quality_of_agricultures')->only(['index']);
        $this->middleware('permission:show-quality_of_agricultures')->only(['show']);
        $this->middleware('permission:create-quality_of_agricultures')->only(['create', 'store']);
        $this->middleware('permission:update-quality_of_agricultures')->only(['edit', 'update']);
        $this->middleware('permission:delete-quality_of_agricultures')->only('destroy');

        $this->middleware('verified');
    }

    protected $redirectTo = '/quality_of_agriculture';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        // return QualityOfAgriculture::with(['agriculture', 'quality'])->get();

        if ($request->ajax()) {
            $qualityOfAgricultures = QualityOfAgriculture::with(['agriculture', 'quality']);

            return DataTables::eloquent($qualityOfAgricultures)
            ->addIndexColumn()
            ->editColumn(
                'agriculture', 
                function (QualityOfAgriculture $value) {
                    return $value->agriculture->agriculture_name;
                })
            ->editColumn(
                'quality',
                function (QualityOfAgriculture $value) {
                    return $value->quality->quality_name;
                })
            ->addColumn('action', function ($qualityOfAgricultures) {
                if (Laratrust::can('update-quality_of_agricultures|delete-quality_of_agricultures')) {

                    return view('inc._action', 
                        [
                            'model' => 'quality_of_agriculture', 
                            'id' => $qualityOfAgricultures->id
                        ]
                    );
                }
            })->toJson(true);

        }

        $html = $htmlBuilder->parameters([
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
            ],
        ]);

        $htmlBuilder->addColumn(
            [
                'data' => 'DT_RowIndex', 
                'name' => 'DT_RowIndex', 
                'title' => 'No', 
                'responsive' => true, 
                'style' => 'width:8%', 
                'orderable' => 'asc', 
                'searchable' => false
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'agriculture', 
                'name' => 'agriculture.agriculture_name', 
                'title' => 'Hasil Pertanian', 
                'responsive' => true, 
                'style' => 'width:40%'
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'quality', 
                'name' => 'quality.quality_name', 
                'title' => 'Kualitas', 
                'responsive' => true, 
                'style' => 'width:35%'
            ]
        );

        if (Laratrust::hasRole('superadministrator')) {
            $htmlBuilder->addColumn(
                [
                    'data' => 'action', 
                    'name' => 'action', 
                    'title' => 'Action', 
                    'orderable' => false, 
                    'searchable' => false
                ]
            );
        }
        
        return view('quality_of_agriculture.index', compact('html'));
    }

    protected function rules() {
        return [
            'agriculture_id' => 'required',
            'quality_id' => 'required',
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agriculture = Agriculture::all();
        $quality = Quality::all();

        return view('quality_of_agriculture.create', compact('agriculture', 'quality'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        QualityOfAgriculture::create([
                'agriculture_id' => $request->input('agriculture_id'),
                'quality_id' => $request->input('quality_id'),
            ]);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QualityOfAgriculture  $qualityOfAgriculture
     * @return \Illuminate\Http\Response
     */
    public function show(QualityOfAgriculture $qualityOfAgriculture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QualityOfAgriculture  $qualityOfAgriculture
     * @return \Illuminate\Http\Response
     */
    public function edit(QualityOfAgriculture $qualityOfAgriculture)
    {
        $agriculture = Agriculture::all();
        $quality = Quality::all();
        $qualityOfAgriculture->with(['agriculture', 'quality'])->get()->first();

        return view('quality_of_agriculture.edit', compact('agriculture', 'quality', 'qualityOfAgriculture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QualityOfAgriculture  $qualityOfAgriculture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualityOfAgriculture $qualityOfAgriculture)
    {
        $this->validate($request, $this->rules());

        $qualityOfAgriculture->update([
                'agriculture_id' => $request->input('agriculture_id'),
                'quality_id' => $request->input('quality_id'),
            ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QualityOfAgriculture  $qualityOfAgriculture
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityOfAgriculture $qualityOfAgriculture)
    {
        $qualityOfAgriculture->delete();

        $response = [
            'success' => TRUE, 
            'message' => 'Data Hasil Pertanian Berhasil Dihapus'
        ];

        return json_encode($response);
    }
}

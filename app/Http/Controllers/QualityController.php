<?php

namespace App\Http\Controllers;

use App\Quality;
use Illuminate\Http\Request;

use Yajra\DataTables\Html\Builder;
use DataTables;
use Laratrust;

class QualityController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-qualities')->only(['index']);
        $this->middleware('permission:show-qualities')->only(['show']);
        $this->middleware('permission:create-qualities')->only(['create', 'store']);
        $this->middleware('permission:update-qualities')->only(['edit', 'update']);
        $this->middleware('permission:delete-qualities')->only('destroy');

        $this->middleware('verified');
    }

    protected $redirectTo = '/quality';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $quality = Quality::query();

            return DataTables::of($quality)
            ->addIndexColumn()
            ->editColumn('quality_name', function ($quality) {
                return $quality->quality_name;
            })
            ->addColumn('action', function ($quality) {
                if (Laratrust::can('update-qualities|delete-qualities')) {

                    return view('inc._action', 
                        [
                            'model' => 'quality', 
                            'id' => $quality->id
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
                'data' => 'quality_name', 
                'name' => 'quality_name', 
                'title' => 'Nama kualitas', 
                'responsive' => true, 
                'style' => 'width:70%'
            ]
        );

        if (Laratrust::hasRole('superadministrator')) {
            $htmlBuilder->addColumn(
                [
                    'data' => 'action', 
                    'name' => 'action', 
                    'title' => 'Action', 
                    'orderable' => false, 
                    'searchable' => false,
                ]
            );
        }

        return view('quality.index', compact('html'));
    }

    protected function rules() {
        return [
            'quality_name' => 'required|string|unique:qualities|max:50',
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quality.create');

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

        Quality::create([
                'quality_name' => $request->input('quality_name'),
                // 'slug' => str_slug($request->input('quality_name')),
            ]);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quality  $quality
     * @return \Illuminate\Http\Response
     */
    public function show(Quality $quality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quality  $quality
     * @return \Illuminate\Http\Response
     */
    public function edit(Quality $quality)
    {
        return view('quality.edit', compact('quality'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quality  $quality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quality $quality)
    {
        $this->validate($request, $this->rules());

        $quality->find($quality->id)->update([
                'quality_name' => $request->input('quality_name'),
                // 'slug' => str_slug($request->input('quality_name')),
            ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quality  $quality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quality $quality)
    {
        $quality->find($quality->id)->delete();

        $response = [
            'success' => TRUE, 
            'message' => 'Data Komoditas Berhasil Dihapus'

        ];

        return json_encode($response);
    }
}

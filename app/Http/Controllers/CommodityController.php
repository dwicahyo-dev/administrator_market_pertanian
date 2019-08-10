<?php

namespace App\Http\Controllers;

use App\Commodity;
use Illuminate\Http\Request;

use Yajra\DataTables\Html\Builder;
use DataTables;
use Validator;
use Laratrust;

class CommodityController extends Controller
{
    protected $path;
    protected $dimention;

    public function __construct()
    {
        $this->middleware('verified');

        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-commodities')->only(['index']);
        $this->middleware('permission:show-commodities')->only(['show']);
        $this->middleware('permission:create-commodities')->only(['create', 'store']);
        $this->middleware('permission:update-commodities')->only(['edit', 'update']);
        $this->middleware('permission:delete-commodities')->only('destroy');
    }

    protected $redirectTo = '/commodity';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $commodity = Commodity::query();

            return DataTables::eloquent($commodity)
            ->addIndexColumn()
            ->editColumn('commodity_name', function ($commodity) {
                return $commodity->commodity_name;
            })
            ->addColumn('action', function ($commodity) {
                if (Laratrust::can('update-commodities|delete-commodities')) {
                    return view('inc._action', 
                        [
                            'model' => 'commodity',
                            'id' => $commodity->id
                        ]
                    );
                }
            })
            ->make(true);
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
                'style' => 'width:9%', 
                'orderable' => 'asc', 
                'searchable' => false
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'commodity_name', 
                'name' => 'commodity_name', 
                'title' => 'Nama Komoditas', 
                'responsive' => true, 
                'style' => 'width:60%'
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

        return view('commodity.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('commodity.create');
    }

    protected function rules() {
        return [
            'commodity_name' => 'required|string|unique:commodities|max:50',
        ];
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

        Commodity::create([
                'commodity_name' => $request->input('commodity_name'),
                // 'slug' => str_slug($request->input('commodity_name'))
            ]);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
        return $commodity;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {
        return view('commodity.edit', compact('commodity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity)
    {
        $this->validate($request, $this->rules());

        $commodity->find($commodity->id)->update([
                'commodity_name' => $request->input('commodity_name'),
                // 'slug' => str_slug($request->input('commodity_name')),
            ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commodity  $commodity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {   
        $commodity->find($commodity->id)->delete();

        $response = [
            'success' => TRUE, 
            'message' => 'Data Komoditas Berhasil Dihapus'

        ];

        return json_encode($response);
    }
}

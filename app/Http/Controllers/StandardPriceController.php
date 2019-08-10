<?php

namespace App\Http\Controllers;

use App\StandardPrice;
use Illuminate\Http\Request;

use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Auth;

use DataTables;
use Laratrust;

use App\Helpers\RupiahHelper as Rupiah;
use App\Agriculture;

class StandardPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-standard_prices')->only('index');
        $this->middleware('permission:show-standard_prices')->only(['show']);
        $this->middleware('permission:create-standard_prices')->only(['create', 'store']);
        $this->middleware('permission:update-standard_prices')->only(['edit', 'update']);
        $this->middleware('permission:delete-standard_prices')->only('destroy');

        $this->middleware('verified');
    }

    protected $redirectTo = '/standard_price';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
             $standard_price = StandardPrice::with(['agriculture']);

            return DataTables::eloquent($standard_price)
            ->addIndexColumn()
            ->editColumn('agriculture_name', function ($value) {
                return $value->agriculture->agriculture_name;
            })
            ->editColumn('lowest_price', function ($value) {
                return Rupiah::format($value->lowest_price);
            })
            ->editColumn('highest_price', function ($value) {
                return Rupiah::format($value->highest_price);
            })
            ->addColumn('action', function ($standard_price) {

                if (Laratrust::can('update-standard_prices|delete-standard_prices')) {

                    return view('inc._action_standar_harga', 
                        [
                            'model' => 'standard_price', 
                            'id' => $standard_price->id
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

        $htmlBuilder
        ->addColumn(
            [
                'data' => 'DT_RowIndex', 
                'name' => 'DT_RowIndex', 
                'title' => 'No', 
                'responsive' => true, 
                'style' => 'width:8%', 
                'orderable' => 'asc', 
                'searchable' => false
            ]
        )
        ->addColumn(
            [
                'data' => 'agriculture_name',
                'name' => 'agriculture.agriculture_name', 
                'title' => 'Hasil Pertanian', 
                'responsive' => true, 
                'style' => 'width:35%'
            ]
        )
        ->addColumn(
            [
                'data' => 'lowest_price', 
                'name' => 'lowest_price', 
                'title' => 'Harga Terendah', 
                'responsive' => true, 
                'style' => 'width:20%'
            ]
        )
        ->addColumn(
            [
                'data' => 'highest_price', 
                'name' => 'highest_price', 
                'title' => 'Harga Tertinggi', 
                'responsive' => true, 
                'style' => 'width:20%'
            ]
        )
        ->addColumn(
            [
                'data' => 'action', 
                'name' => 'action', 
                'title' => 'Action', 
                'orderable' => false, 
                'searchable' => false
            ]
        );

        return view('standard_price.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agricultures = Agriculture::all();

        return view('standard_price.create', compact('agricultures'));
    }

    protected function rules() {
        return [
            'agriculture_id' => 'required|unique:standard_prices',
            'lowest_price' => 'required|min:3|max:10|not_in:0|lt:highest_price',
            'highest_price' => 'required|min:3|max:10|gt:lowest_price',
        ];
    }

    protected function rulesUpdate() {
        return [
            // 'agriculture_id' => 'required',
            'lowest_price' => 'required|min:0|max:10|lt:highest_price',
            'highest_price' => 'required|min:0|max:10|gt:lowest_price',
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

        StandardPrice::create([
                'agriculture_id' => $request->input('agriculture_id'),
                'user_id' => Auth::user()->id,
                'lowest_price' => $request->input('lowest_price'),
                'highest_price' => $request->input('highest_price'),
            ]);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StandardPrice  $standardPrice
     * @return \Illuminate\Http\Response
     */
    public function show(StandardPrice $standardPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StandardPrice  $standardPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardPrice $standardPrice)
    {
        $agricultures = Agriculture::all();
        
        return view('standard_price.edit', compact('agricultures', 'standardPrice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StandardPrice  $standardPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StandardPrice $standardPrice)
    {
        $this->validate($request, $this->rulesUpdate());

        $standardPrice->update([
                'agriculture_id' => $standardPrice->agriculture_id,
                'lowest_price' => $request->input('lowest_price'),
                'highest_price' => $request->input('highest_price'),
            ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StandardPrice  $standardPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(StandardPrice $standardPrice)
    {
        $standardPrice->delete();

        $response = [
            'success' => TRUE, 
            'message' => 'Data Standar Harga Berhasil Dihapus'
        ];

        return json_encode($response);
    }
}

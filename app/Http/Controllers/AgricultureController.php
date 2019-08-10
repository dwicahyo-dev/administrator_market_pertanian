<?php

namespace App\Http\Controllers;

use App\Agriculture;
use App\Commodity;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use DataTables;
use Validator;
use Laratrust;
use Illuminate\Support\Facades\Storage;
use Image;
use Carbon\Carbon;
use File;

class AgricultureController extends Controller
{
    protected $path;
    protected $filePath = 'public/agricultures/';

    public function __construct()
    {
        $this->middleware('verified');

        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-agricultures')->only(['index']);
        $this->middleware('permission:show-agricultures')->only(['show']);
        $this->middleware('permission:create-agricultures')->only(['create', 'store']);
        $this->middleware('permission:update-agricultures')->only(['edit', 'update']);
        $this->middleware('permission:delete-agricultures')->only('destroy');

        $this->path = storage_path('app/public/agricultures');
    }

    protected $redirectTo = '/agriculture';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $agricultures = Agriculture::with('commodity');

            return DataTables::eloquent($agricultures)
                ->addIndexColumn()
                ->editColumn('agriculture_name', function ($agricultures) {
                    return $agricultures->agriculture_name;
                })
                ->editColumn('commodity.commodity_name', function ($agricultures) {
                    return $agricultures->commodity->commodity_name;
                })
                ->addColumn('thumbnail', function ($agricultures) {
                    return view(
                        'inc._image',
                        [
                            'src' => $this->filePath . $agricultures->thumbnail
                        ]
                    );
                })
                ->addColumn('action', function ($agricultures) {
                    if (Laratrust::can('update-agricultures|delete-agricultures')) {

                        return view(
                            'inc._action',
                            [
                                'model' => 'agriculture',
                                'id' => $agricultures->id
                            ]
                        );
                    }
                })
                ->rawColumns(['thumbnail' => 'thumbnail'])
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
                'style' => 'width:10%',
                'orderable' => 'asc',
                'searchable' => false
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'agriculture_name',
                'name' => 'agriculture_name',
                'title' => 'Nama Hasil Pertanian',
                'responsive' => true,
                'style' => 'width:30%'
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'commodity.commodity_name',
                'name' => 'commodity.commodity_name',
                'title' => 'Komoditas',
                'responsive' => true,
                'style' => 'width:18%'
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'thumbnail',
                'name' => 'thumbnail',
                'title' => 'Thumbnail',
                'responsive' => true,
                'style' => 'width:25%',
                'orderable' => false,

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

        return view('agriculture.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commodities = Commodity::all();

        return view('agriculture.create', compact('commodities'));
    }

    protected function rules()
    {
        return [
            'agriculture_name' => 'required|string|unique:agricultures',
            'commodity_id' => 'required',
            'thumbnail' => 'required|image:jpeg,png,jpg|max:5000',
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

        $dataUpload = [
            'file_thumbnail' => $request->file('thumbnail'),
        ];

        $uploadedFile = $this->doUpload($dataUpload);

        Agriculture::create([
            'commodity_id' => $request->input('commodity_id'),
            'agriculture_name' => $request->input('agriculture_name'),
            'thumbnail' => $uploadedFile,
        ]);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

        return redirect($this->redirectTo);
    }

    /**
     * Do Uploading the Product Photo
     *
     * @param object $data
     * @return void
     */
    public function doUpload(array $dataUpload)
    {
        if (!File::isDirectory($this->path)) {
            File::makeDirectory($this->path);
        }

        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.png';

        $canvas = Image::canvas(640, 709);

        $resizeImage  = Image::make($dataUpload['file_thumbnail'])->resize(640, 709, function ($constraint) {
            $constraint->aspectRatio();
        });

        $canvas->insert($resizeImage, 'center');
        $canvas->save($this->path . '/' . $fileName);

        return $fileName;
    }

    public function doUploadUpdate(array $dataUpload, $agriculture)
    {
        if (!File::isDirectory($this->path)) {
            File::makeDirectory($this->path);
        }

        if (Storage::exists($this->filePath . $agriculture->thumbnail)) {
            Storage::delete($this->filePath . $agriculture->thumbnail);
        }

        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.png';

        $canvas = Image::canvas(640, 709);

        $resizeImage  = Image::make($dataUpload['file_thumbnail'])->resize(640, 709, function ($constraint) {
            $constraint->aspectRatio();
        });

        $canvas->insert($resizeImage, 'center');
        $canvas->save($this->path . '/' . $fileName);

        $agriculture->update([
            'thumbnail' => $fileName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function show(Agriculture $agriculture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function edit(Agriculture $agriculture)
    {
        $commodities = Commodity::all();

        return view('agriculture.edit', compact('agriculture', 'commodities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agriculture $agriculture)
    {
        if (!$request->hasFile('thumbnail')) {
            $validator = Validator::make($request->only(['agriculture_name', 'commodity_id']), [
                'agriculture_name' => 'required|string',
                'commodity_id' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->only('thumbnail'), [
                'thumbnail' => 'required|image:jpeg,png,jpg|max:5000',
            ]);
        }

        if ($validator->fails()) {
            return redirect()
                ->route('agriculture.edit', $agriculture->id)
                ->withErrors($validator)
                ->withInput();
        }

        $dataUpload = [
            'file_thumbnail' => $request->file('thumbnail'),
        ];

        if ($request->hasFile('thumbnail')) {
            $this->doUploadUpdate($dataUpload, $agriculture);
        }

        $agriculture->update([
            'commodity_id' => $request->input('commodity_id'),
            'agriculture_name' => $request->input('agriculture_name'),
        ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agriculture $agriculture)
    {
        if (Storage::exists($this->filePath . $agriculture->thumbnail)) {
            Storage::delete($this->filePath . $agriculture->thumbnail);
        }

        $agriculture->delete();

        $response = [
            'success' => TRUE,
            'message' => 'Data Hasil Pertanian Berhasil Dihapus'
        ];

        return json_encode($response);
    }
}

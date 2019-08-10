<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use DataTables;

use Laratrust;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');

        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-users')->only('index');
        $this->middleware('permission:show-users')->only(['show']);
        $this->middleware('permission:create-users')->only(['create', 'store']);
        $this->middleware('permission:update-users')->only(['edit', 'update']);
        $this->middleware('permission:delete-users')->only('destroy');
    }

    protected $redirectTo = '/users';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $users = User::with(['userRoles']);

            return DataTables::eloquent($users)
            ->addIndexColumn()
            ->editColumn('name', function ($users) {
                return $users->name;
            })
            ->editColumn('email', function ($users) {
                return $users->email;
            })
            ->addColumn('action', function ($users) {
                if (Laratrust::can('update-users|delete-users')) {

                    return view('inc._action', 
                        [
                            'model' => 'users', 
                            'id' => $users->id
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
                'data' => 'name', 
                'name' => 'name', 
                'title' => 'Nama Users', 
                'responsive' => true, 
                'style' => 'width:38%'
            ]
        );
        
        $htmlBuilder->addColumn(
            [
                'data' => 'email', 
                'name' => 'email', 
                'title' => 'Email', 
                'responsive' => true, 
                'style' => 'width:38%'
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
        
        return view('users.index', compact('html'));
    }

    protected function rules() {
        return [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
        ];
    }

    protected function rulesUpdate() {
        return [
            'name' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
        
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('password')
        ]);

        $request->session()->flash('success', 'Data Users Berhasil Disimpan, dengan isian Password bawaan Users : password ');

        return redirect($this->redirectTo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, $this->rulesUpdate());

        $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $response = [
            'success' => TRUE, 
            'message' => 'Data User Berhasil Dihapus'
        ];

        return json_encode($response);
    }
}

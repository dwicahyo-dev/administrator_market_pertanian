<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use DataTables;
use Laratrust;

use App\User;
use App\Role;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');

        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:read-users_role')->only('index');
        $this->middleware('permission:show-users_role')->only(['show']);
        $this->middleware('permission:create-users_role')->only(['create', 'store']);
        $this->middleware('permission:update-users_role')->only(['edit', 'update']);
        $this->middleware('permission:delete-users_role')->only('destroy');
    }

    protected $redirectTo = '/users_role';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $users = User::with(['userRoles']);

            return DataTables::eloquent($users)->addIndexColumn()->editColumn('name', function ($users) {
                    return $users->name;
                })->editColumn('email', function ($users) {
                    return $users->email;
                })->editColumn('userRoles', function (User $value) {
                    foreach ($value->userRoles as $roles) {
                        return $roles->display_name;
                    }
                })->addColumn('action', function ($users) {
                    if (Laratrust::can('delete-users_role')) {

                        return view('inc._action_users_role', [
                            'model' => 'users_role', 
                            'id' => $users->id
                            ]);
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
                'title' => 'Nama User', 
                'responsive' => true, 
                'style' => 'width:25%'
            ]
        );
        
        $htmlBuilder->addColumn(
            [
                'data' => 'email', 
                'name' => 'email', 
                'title' => 'Email', 
                'responsive' => true, 
                'style' => 'width:30%'
            ]
        );

        $htmlBuilder->addColumn(
            [
                'data' => 'userRoles',
                'name' => 'userRoles.display_name', 
                'title' => 'Roles', 
                'responsive' => true, 
                'style' => 'width:20%'
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

        return view('users_role.index', compact('html'));
    }

    protected function messages() {
        return [
            'user_id.required' => 'User wajib diisi',
            'user_id.unique' => 'Isian user sudah ada sebelumnya.',
            'role_id.required' => 'Role wajib diisi',
        ];
    }

    protected function rules() {
        return [
            'user_id' => 'required|unique:role_user',
            'role_id' => 'required',
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $roles = Role::all();

        return view('users_role.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        
        $user_id = $request->input('user_id');
        $role_id = $request->input('role_id');

        $user = User::find($user_id);

        $user->attachRole($role_id);

        $request->session()->flash('success', 'Data Berhasil Disimpan');

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        foreach ($user->userRoles as $roles) {
            $user->detachRole($roles->id);
        }

        $response = [
            'success' => TRUE, 
            'message' => 'Data User Role Berhasil Dihapus'
        ];

        return json_encode($response);        
    }
}

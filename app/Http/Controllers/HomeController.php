<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Commodity;
use App\Quality;
use App\Agriculture;
use App\QualityOfAgriculture;
use App\StandardPrice;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified')->only(['updateProfile', 'updatePassword']);
    }

    protected $redirectTo = '/profile';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count = [
            'count_commodities' => Commodity::count(),
            'count_quality' => Quality::count(),
            'count_agriculture' => Agriculture::count(),
            // 'count_quality_of_agriculture' => QualityOfAgriculture::count(),
            'count_standard_price' => StandardPrice::count(),
            'count_users' => User::count(),
        ];

        return view('home', compact('count'));
    }

    protected function rulesProfile() {
        return [
            'name' => 'required',
            'email' => 'required',
        ];
    }

    protected function rulesPassword() {
        return [
            'password' =>  'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function profile()
    {
        $profile = User::with('userRoles')->where('id', Auth::user()->id)->get()->first();

        return view('layouts.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, $this->rulesProfile());

        User::where('id', Auth::user()->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);        
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, $this->rulesPassword());

        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->input('password')),
        ]);

        $request->session()->flash('success', 'Data Berhasil Diubah');

        return redirect($this->redirectTo);
    }
}

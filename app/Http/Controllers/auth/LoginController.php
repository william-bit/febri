<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
        $this->username = 'username';
    }
    public function index()
    {
        return view('pages.auth.index');
    }
    public function check(Request $request)
    {
        Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ])->validate();
        $credentials = $request->only('username','password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            if(auth()->user()->role_id === 1){
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('home');
            }
        }else{
            $errors = ['fail'=>'Fail Login try again'];
            return redirect()->route('login')->withErrors($errors);
        }
    }
}

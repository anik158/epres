<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'loginPost', 'signup', 'store']);
    }

    public function signup()
    {
        return view('signup-page');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'terms' => 'required'
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);


        return back()->with('success', 'Register successfully');
    }

    public function login()
    {
        return view('login-page');
    }

    public function loginPost(Request $request)
    {
        $login = $request->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field => $login,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->route('dashboard')->with('success', 'Login success');
        }

        return back()->with('error', 'Username/Email or Password failed');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function tableData(){
        return view('tables-data');
    }

}

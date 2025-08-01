<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request) {

        $credentials =$request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            $user = Auth::user();
            return match ($user->role){
                'admin' => redirect()->intended('/admin'),
                'manager' => redirect()->intended('/manager'),
            };
        }

        return back()->with('failed', 'email atau password salah');
    }


    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Berhasil Logout!');
    }
}

<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        return match ($user->role){
            'manager' => redirect()->route('manager.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect('/login')
        };
    }

    public function cek()
    {
        return $this->dashboard();
    }

}

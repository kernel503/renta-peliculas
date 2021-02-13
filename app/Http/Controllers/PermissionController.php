<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index()
    {
    }

    public function changeRol()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return view('administrator/rol');
        }
        return redirect('/tienda');
    }
}

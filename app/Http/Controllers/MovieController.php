<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return view('administrator/movie', ['id' => Auth::user()->id]);
        }
        return redirect('/tienda');
        // return view('administrator/movie', ['id' => Auth::user()->id]);
    }

    public function moviestore()
    {
        if (Auth::check()) {
            return view('client/moviestore', ['id' => Auth::user()->id]);
        }
        return redirect('/home');
    }
}

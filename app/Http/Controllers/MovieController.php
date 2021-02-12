<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Route::get('/categoria', function () {
    //     if (Auth::user()->is_admin) {
    //         return response()->json(['admin' => 'categoria']);
    //     }
    //     return redirect('/home');
    // });
    public function index()
    {
        return view('administrator/movie', ['id' => Auth::user()->id]);
    }
}

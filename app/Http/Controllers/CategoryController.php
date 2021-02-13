<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return view('administrator/category');
        }
        return redirect('/tienda');
    }
}

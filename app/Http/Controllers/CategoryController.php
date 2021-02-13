<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\UsersExport;
use App\Exports\MoviesExport;
use App\Http\Controllers\Controller;
use App\Movie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{

    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return view('administrator/category');
        }
        return redirect('/tienda');
    }

    function categoryexport()
    {
        return Excel::download(new MoviesExport, 'movies.xlsx');
    }

    function userexport()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    function movementexport()
    {
        dd('waiting');
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}

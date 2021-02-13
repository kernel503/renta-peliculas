<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return view('administrator/movie', ['id' => Auth::user()->id]);
        }
        return redirect('/tienda');
    }

    public function moviestore()
    {
        if (Auth::check()) {
            return view('client/moviestore', ['id' => Auth::user()->id]);
        }
        return redirect('/home');
    }

    public function moviepurchase()
    {
        if (Auth::check()) {
            $shopping = DB::table('shopping')
                ->join('movies', 'shopping.movie_id', '=', 'movies.id')
                ->join('categories', 'movies.category_id', '=', 'categories.id')
                ->where('user_id', Auth::id())
                ->select('shopping.created_at', 'movies.movie_name', 'categories.category_name')
                ->get();

            $rental = DB::table('rental')
                ->join('movies', 'rental.movie_id', '=', 'movies.id')
                ->join('categories', 'movies.category_id', '=', 'categories.id')
                ->where('user_id', Auth::id())
                ->select('rental.created_at', 'movies.movie_name', 'categories.category_name')
                ->get();

            return view(
                'client/moviestorepurchase',
                [
                    'id' => Auth::user()->id,
                    'shoppingList' => $shopping,
                    'list' => $rental
                ]
            );
        }
        return redirect('/home');
    }
}

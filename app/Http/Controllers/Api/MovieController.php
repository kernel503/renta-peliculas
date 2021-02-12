<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return Movie::all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'movie_name' => 'required',
            'release_date' => 'required',
            'img_url' => 'required',
            'quantity_stock' => 'required',
            'sale_price' => 'required',
            'rent_price' => 'required',
            'available' => 'required',
            'category_id' => 'required',
        ]);

        $collectionRequest = collect($request);
        $id = $collectionRequest->get('id');
        $collection = $collectionRequest->only([
            'movie_name',
            'release_date',
            'img_url',
            'quantity_stock',
            'sale_price',
            'rent_price',
            'available',
            'category_id'
        ]);

        Movie::updateOrCreate(
            ['id' => $id],
            $collection->toArray()
        );

        // Movie::create($request->all());
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieStore;
use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    }

    public function catalogue()
    {
        return MovieStore::collection(Movie::where('available', true)->get());
    }

    public function record()
    {
        return MovieStore::collection(Movie::where('available', true)->get());
    }

    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'option' => 'required',
            'user_id' => 'required',
            'movie_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["mensaje" => "Campos invalidos"], 400);
        }
        $collection = collect($request);
        $option = $collection->get('option');
        $optionsAvailable = array(0, 1);

        if (!in_array($option,  $optionsAvailable)) {
            return response()->json(["mensaje" => "Opción Invalida"], 400);
        }

        //1 Compra, 0 Rentado
        if ($option) {
        }

        return response()->json(["mensaje" => "Transacción realizada"]);
    }
}

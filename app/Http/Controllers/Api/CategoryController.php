<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return Category::all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
        Category::create($request->all());
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->category_name;
        $category = Category::find($id);
        $category->category_name = $name;
        $category->save();
    }
}

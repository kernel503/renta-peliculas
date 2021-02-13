<?php

namespace App\Exports;

use App\Category;
use App\Movie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MoviesExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    $categories = Category::all()->toArray();
    $collect = collect([]);
    foreach ($categories as $category) {
      $id = $category['id'];
      $movies = Movie::where('category_id', $id)->get();
      foreach ($movies as $movie) {
        $collect->push([
          'categoria' => $category['category_name'],
          'nombre_pelicula' => $movie['movie_name']
        ]);
      }
    }
    return $collect;
  }

  public function headings(): array
  {
    return [
      'Categoria',
      'Películas',
    ];
  }
}

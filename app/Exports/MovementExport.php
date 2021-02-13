<?php

namespace App\Exports;

use App\Movie;
use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovementExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    $movies = Movie::all()->toArray();
    $collection = collect([]);
    foreach ($movies as $movie) {
      $count_rent = DB::table('rental')->where('movie_id', $movie['id'])->count();
      $count_shop = DB::table('shopping')->where('movie_id', $movie['id'])->count();
      $collection->push([
        'nombre' => $movie['movie_name'],
        'alquilada' => $count_rent,
        'vendidas' => $count_shop
      ]);
    }
    return $collection;
  }

  public function headings(): array
  {
    return [
      'Película',
      'Cantidad rentada',
      'Cantidad vendida',
    ];
  }
}

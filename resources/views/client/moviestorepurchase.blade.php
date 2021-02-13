@extends('layouts.app')

@section('content')
    @guest
        Debes estar registrado para visitar el sitio.
    @else

    <div class="container">
        <div class="row">
          <div class="col-sm">
            <h3><span class="badge bg-info text-dark fs-1">{{ __('Películas Alquiladas') }}</span></h3>
            <ul class="list-group list-group-flush mt-3">
                @forelse ($list as $rent)                    
                    <li class="list-group-item">{{ date("dS M Y",strtotime($rent->created_at)) }} - {{ $rent->movie_name }}</li>              
                @empty
                    <li class="list-group-item">{{ __('No hay registro') }}</li>
                @endforelse  
            </ul>                  
          </div>
          <div class="col-sm">
            <h3><span class="badge bg-light text-dark">{{ __('Películas Compradas') }}</span></h3>         
            <ul class="list-group list-group-flush mt-3">
                @forelse ($shoppingList as $shop)                    
                    <li class="list-group-item">{{ date("dS M Y",strtotime($shop->created_at)) }} - {{ $shop->movie_name }}</li>              
                @empty
                    <li class="list-group-item">{{ __('No hay registro') }}</li>
                @endforelse  
            </ul>    
          </div>
        </div>
      </div>
            
    @endguest

@endsection

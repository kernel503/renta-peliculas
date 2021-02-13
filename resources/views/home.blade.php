@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Visita el sitio') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                        Invitado
                    @else
                        @if(Auth::user()->is_admin)    
                        <div class="container">
                            <div class="row">
                              <div class="col-sm">
                                <a type="button" href="{{ route('category-exports') }}" class="btn btn-outline-info">Descargar informe películas</a>
                              </div>
                              <div class="col-sm">
                                <a type="button" href="{{ route('user-exports') }}" class="btn btn-outline-success">Descargar informe usuarios</a>
                              </div>
                              <div class="col-sm">
                                <a type="button" href="{{ route('movement-exports') }}" class="btn btn-outline-dark">Descargar informe movimientos</a>
                              </div>
                            </div>
                          </div>                                
                        @else
                            Bienvenido!!                               
                        @endif               
                    @endguest
          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

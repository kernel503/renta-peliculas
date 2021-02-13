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
                            Es un administrador!!!
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

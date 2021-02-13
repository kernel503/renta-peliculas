@extends('layouts.app')

@section('content')
    @guest
        Debes estar registrado para visitar el sitio.
    @else
        <div id="app">
            <Movie-Store user_id="{{$id}}"/>        
        </div>              
    @endguest

@endsection

@extends('error')

@section('title', 'Unauffindbar')

@section('content')
    <h1 class="font-size-80">
        <i class="icon text-primary fa-search"></i>
        404
    </h1>
    <p class="error-advise">Leider konnten wir absolut nichts passendes zu deiner Anfrage finden.</p>
    <a class="btn btn-primary" href="{{ url('/') }}">Startseite</a>
@endsection
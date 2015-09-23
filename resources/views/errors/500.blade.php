@extends('error')

@section('title', 'Verwirrung')

@section('content')
    <h1 class="font-size-80">
        <i class="icon text-danger fa-bomb"></i>
        500
    </h1>
    <p class="error-advise">
        Du hast unseren Server sehr verwirrt!
        <br/>
        Überprüfe noch einmal alles - ansonsten melde dich bei einem Amdin.
    </p>
    <a class="btn btn-primary" href="{{ url('/') }}">Startseite</a>
@endsection
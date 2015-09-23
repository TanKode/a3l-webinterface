@extends('error')

@section('title', 'Unbefugt')

@section('content')
    <h1 class="font-size-80">
        <i class="icon text-warning fa-key"></i>
        403
    </h1>
    <p class="error-advise">Leider bist du nicht berechtigt diesen bereich der Seite zu sehen.</p>
    <a class="btn btn-primary" href="{{ url('/') }}">Startseite</a>
@endsection
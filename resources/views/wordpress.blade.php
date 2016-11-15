@extends('master')

@section('body-class')
    @if(!\Auth::check()) am-splash-screen @endif
@endsection

@section('pre-content')
    @if(\Auth::check())
        @include('partials.navbar')
        @include('partials.menubar')
    @endif
@endsection

@section('layout')
    @yield('content')
@endsection
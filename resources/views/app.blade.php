@extends('master')

@section('pre-content')
    @include('partials.navbar')
    @include('partials.menubar')
@endsection

@section('layout')
    @yield('content')
@endsection

@section('post-content')
@endsection
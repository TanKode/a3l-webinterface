@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
            @yield('content')
        </div>
    </div>
@endsection
@extends('master')

@section('bodyClass', 'layout-full error-layout')

@section('layout')
    <div class="page vertical-align text-center">
        <div class="page-content vertical-align-middle">
            @yield('content')
        </div>
    </div>
@endsection
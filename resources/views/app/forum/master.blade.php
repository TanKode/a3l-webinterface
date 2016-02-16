@extends('master')

@section('title', trans('menu.forum'))

@section('body-class', 'am-aside')
@section('content-class', 'am-no-padding')

@section('pre-content')
    @include('partials.navbar')
    @include('partials.menubar')
@endsection

@section('page-head')
    @include('app.forum.partials.sidebar')
@endsection

@section('layout')
    @include('forum::partials.alerts')

    @yield('content')
@endsection

@section('post-content')
    @yield('footer')
@endsection

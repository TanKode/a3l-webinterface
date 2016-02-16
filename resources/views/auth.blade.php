@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="text-center">
        <h1 class="white">{{ trans('messages.title') }}</h1>
    </div>
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('auth.widgets.credentials')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('auth.widgets.youtube')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.links')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.a3lserver')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.ts3server')
        </div>
    </div>
@endsection
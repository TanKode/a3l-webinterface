@extends('app')

@section('title', trans('menu.dashboard'))

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.dynmarket')
        </div>
        <div class="col-md-6 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.a3lserver')
        </div>
        <div class="col-md-6 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.ts3server')
        </div>
        @if(\Auth::user()->player)
            <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
                @include('app.dashboard.widgets.player')
            </div>
        @endif
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.links')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.players')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.cops')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.medics')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.money')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.vehicles')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.gangs')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.gangbank')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.users')
        </div>
    </div>
@endsection
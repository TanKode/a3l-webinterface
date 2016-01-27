@extends('app')

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.dynmarket')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.a3lserver')
        </div>
        @if(\Auth::User()->player)
            <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
                @include('app.dashboard.widgets.player')
            </div>
        @endif
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
            @include('app.dashboard.widgets.atacs')
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
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.events')
        </div>
    </div>
@endsection
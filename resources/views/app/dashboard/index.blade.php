@extends('app')

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.players')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.vehicles')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.houses')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.gangs')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.users')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.events')
        </div>
        @if(\Auth::User()->player)
            <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
                @include('app.dashboard.widgets.player')
            </div>
        @endif
    </div>
@endsection
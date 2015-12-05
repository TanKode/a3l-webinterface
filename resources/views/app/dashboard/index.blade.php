@extends('app')

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.players')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.vehicles')
        </div>
        @if(\Auth::User()->player)
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.player')
        </div>
        @endif
    </div>
@endsection
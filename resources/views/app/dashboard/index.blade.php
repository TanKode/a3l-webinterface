@extends('app')

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            <div class="panel panel-alt4">
                <div class="panel-heading">
                    <div class="tools"></div>
                    <span class="title">{{ trans('messages.dynmarket') }}</span>
                </div>
                <div class="padding-15">
                    <div class="row">
                        @foreach($dynmarket as $product)
                            @if($product[1] != 0)
                                <div class="col-md-6">
                                    <strong>{{ transd('products.'.$product[0], $product[0]) }}</strong>
                                    <span class="pull-right">{{ \Formatter::money($product[1]) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.players')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.money')
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
            @include('app.dashboard.widgets.gangbank')
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
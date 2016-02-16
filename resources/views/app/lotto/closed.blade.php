@extends('app')

@section('title', trans('menu.lotto'))

@section('content')
    <div class="panel">
        <header class="panel-heading">
            <h4 class="panel-title">{{ trans('messages.lotto') }}</h4>
        </header>
        {!! Alert::warning(trans('messages.lotto_closed')) !!}
    </div>
@endsection
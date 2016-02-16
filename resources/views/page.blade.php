@extends('master')

@section('body-class')
    @if(!\Auth::check()) am-splash-screen @endif
@endsection

@section('pre-content')
    @if(\Auth::check())
        @include('partials.navbar')
        @include('partials.menubar')
    @endif
@endsection

@section('layout')
    @if(!\Auth::check())
    <div class="container">
    @endif
        <div class="panel">
            <div class="panel-body">
                {!! \MarkExtra::parse($content, false) !!}
            </div>
            @if(!\Auth::check())
            <div class="btn-group btn-group-justified">
                <a class="btn btn-primary btn-block" href="@if(\URL::previous() != \URL::current()) {{ \URL::previous() }} @else {{ url('/') }} @endif">{{ trans('messages.back') }}</a>
                <a class="btn btn-primary btn-block" href="{{ url('/') }}">{{ trans('messages.home') }}</a>
            </div>
            @endif
        </div>
    @if(!\Auth::check())
    </div>
    @endif
@endsection
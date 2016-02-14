@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="container">
        <div class="panel">
            <div class="panel-body">
                {!! \MarkExtra::parse($content) !!}
            </div>
            <div class="btn-group btn-group-justified">
            <a class="btn btn-primary btn-block" href="@if(\URL::previous() != \URL::current()) {{ \URL::previous() }} @else {{ url('/') }} @endif">{{ trans('messages.back') }}</a>
            <a class="btn btn-primary btn-block" href="{{ url('/') }}">{{ trans('messages.home') }}</a>
            </div>
        </div>
    </div>
@endsection
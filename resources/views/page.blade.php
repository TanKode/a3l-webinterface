@extends('master')

@section('title')
    @if(isset($wppost))
        {{ get_the_title($wppost) }}
    @endif
@endsection

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
        <article class="panel">
            <section class="panel-body">
                {!! \MarkExtra::parse($content, false) !!}
            </section>
            @if(!\Auth::check())
            <div class="btn-group btn-group-justified">
                <a class="btn btn-primary btn-block" href="@if(\URL::previous() != \URL::current()) {{ \URL::previous() }} @else {{ url('/') }} @endif">{{ trans('messages.back') }}</a>
                <a class="btn btn-primary btn-block" href="{{ url('/') }}">{{ trans('messages.home') }}</a>
            </div>
            @endif
        </article>
    @if(!\Auth::check())
    </div>
    @endif
@endsection
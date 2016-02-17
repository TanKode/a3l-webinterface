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
                @if(isset($content))
                    <section class="panel-body">
                        {!! \MarkExtra::parse($content, false) !!}
                    </section>
                @elseif(isset($wppost))
                    <header class="panel-heading">
                        <h2 class="panel-title">{{ get_the_title($wppost) }}</h2>
                    </header>
                    <section class="padding-horizontal-20 padding-bottom-30">
                        {!! \Michelf\MarkdownExtra::defaultTransform($wppost->post_content) !!}
                    </section>
                @endif
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
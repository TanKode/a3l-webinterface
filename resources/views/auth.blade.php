@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
            <div class="text-center">
                <h1 class="white">{{ trans('messages.title') }}</h1>
            </div>

            @yield('content')

            <div class="text-center">
                {{ trans('messages.title') }} © 2015 <a href="https://gummibeer.de">Gummibeer</a>
                <br/>
                v{{ config('a3lwebinterface.version') }}
            </div>
        </div>
    </div>
@endsection
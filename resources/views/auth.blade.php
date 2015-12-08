@extends('master')

@section('body-class', 'am-splash-screen')

@section('layout')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
            <div class="text-center">
                <h1 class="white">{{ trans('messages.title') }}</h1>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><a href="{{ url('auth/login') }}" class="btn btn-block text-uppercase @if(Request::is('auth/login')) btn-default @else btn-primary @endif">{{ trans('messages.signin') }}</a></p>
                </div>
                <div class="col-md-6">
                    <p><a href="{{ url('auth/register') }}" class="btn btn-block text-uppercase @if(Request::is('auth/register')) btn-default @else btn-primary @endif">{{ trans('messages.signup') }}</a></p>
                </div>
            </div>

            @yield('content')

            <div class="text-center">
                @include('partials.footer')
            </div>
        </div>
    </div>
@endsection
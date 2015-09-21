@extends('master')

@section('title', 'Anmelden')
@section('bodyClass', 'layout-full auth-layout')

@section('layout')
<div class="page vertical-align text-center">
    <div class="page-content vertical-align-middle">
        <div class="panel">
            <div class="panel-heading">
                <div class="brand">
                    <i class="icon fa-gamepad icon-5x"></i>
                    <p class="brand-text font-size-20">Bambusfarm</p>
                </div>
            </div>
            <div class="nav-tabs-horizontal">
                <ul class="nav nav-tabs nav-justified" data-plugin="nav-tabs">
                    <li @if(Request::is('auth/login')) class="active" @endif><a data-toggle="tab" href="#authLogin">Anmelden</a></li>
                    <li @if(Request::is('auth/register')) class="active" @endif><a data-toggle="tab" href="#authRegister">Registrieren</a></li>
                </ul>
                <div class="tab-content">
                    <div class="panel-body tab-pane active" id="authLogin">
                        @include('auth.signin')
                    </div>
                    <div class="panel-body tab-pane" id="authRegister">
                        @include('auth.signup')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
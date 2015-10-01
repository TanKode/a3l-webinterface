@extends('master')

@section('title', 'Anmelden')
@section('bodyClass', 'layout-full auth-layout')

@section('layout')
    <div class="page" style="background: url('{{ asset('img/auth-background-'.round(rand(1,5)).'.jpg') }}') no-repeat;">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6 hidden-xs">
                <div class="brand">
                    <h1 class="white font-size-80 text-uppercase">Bambusfarm</h1>
                    <h2 class="white font-size-24 text-uppercase">Arma 3 | Altis Life | Minecraft | Community</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 bg-white vertical-align-middle">
                <div class="text-center visible-xs">
                    <i class="icon fa-gamepad text-primary icon-5x"></i>
                    <h3 class="brand-text font-size-24">Bambusfarm</h3>
                </div>
                <div class="nav-tabs-horizontal">
                    <ul class="nav nav-tabs nav-justified" data-plugin="nav-tabs">
                        <li @if(Request::is('auth/login')) class="active" @endif><a data-toggle="tab" href="#authLogin">Anmelden</a></li>
                        <li @if(Request::is('auth/register')) class="active" @endif><a data-toggle="tab" href="#authRegister">Registrieren</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="padding-15 tab-pane @if(Request::is('auth/login')) active @endif" id="authLogin">
                            @include('auth.signin')
                        </div>
                        <div class="padding-15 tab-pane @if(Request::is('auth/register')) active @endif" id="authRegister">
                            @include('auth.signup')
                        </div>
                    </div>
                </div>
                <div class="padding-15 padding-top-0">
                    <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-labeled social-facebook">
                        <span class="btn-label"><i class="icon fa-facebook"></i></span>
                        Facebook
                    </a>
                    <a href="{{ url('auth/github') }}" class="btn btn-block btn-labeled social-github">
                        <span class="btn-label"><i class="icon fa-github"></i></span>
                        Github
                    </a>
                    <a href="{{ url('auth/slack') }}" class="btn btn-block btn-labeled social-slack">
                        <span class="btn-label"><i class="icon fa-slack"></i></span>
                        Slack
                    </a>
                </div>

                <footer class="clearfix padding-15 text-center">
                    <p>
                        © 2015 by <a href="http://bambusfarm.net">Bambusfarm</a> | all rights reserved
                        <br/>
                        created by <a href="https://github.com/Gummibeer">Gummibeer</a>
                    </p>
                    <div>
                        <a href="https://www.paypal.me/gummibeer/5" target="_blank" class="btn btn-xs btn-outline btn-info"><i class="fa-paypal"></i> unterstützen</a>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
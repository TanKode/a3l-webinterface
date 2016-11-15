@extends('master')

@section('bodyClass', '')

@section('layout')
    <nav class="site-navbar navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided" data-toggle="menubar">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
                <i class="icon wb-more-horizontal"></i>
            </button>
            <div class="navbar-brand navbar-brand-center site-gridmenu-toggle">
                <span class="navbar-brand-logo">
                    <i class="icon fa-gamepad"></i>
                </span>
                <span class="navbar-brand-text">
                    Bambusfarm
                </span>
            </div>
        </div>

        <div class="navbar-container container-fluid">
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                <ul class="nav navbar-toolbar">
                    <li class="hidden-float" id="toggleMenubar">
                        <a data-toggle="menubar" href="javascript:void(0)">
                            <i class="icon hamburger hamburger-arrow-left">
                                <span class="sr-only">Toggle menubar</span>
                                <span class="hamburger-bar"></span>
                            </i>
                        </a>
                    </li>
                </ul>

                @include('partials.app.navbarright')
            </div>
        </div>
    </nav>
    @include('partials.app.sitemenubar')


    <div class="page">
        <div class="page-content padding-25 container-fluid">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')
@endsection
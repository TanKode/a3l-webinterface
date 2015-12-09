@extends('master')

@section('pre-content')
    @include('partials.navbar')
    @include('partials.menubar')
@endsection

@section('page-head')
    <div class="page-head">
        <h2>{{ trans('menu.forum') }}</h2>
        @include('forum::partials.breadcrumbs')
    </div>
@endsection

@section('layout')
    @include('forum::partials.alerts')

    @yield('content')
@endsection

@section('post-content')
    @yield('footer')
    <script src="{{ asset('js/modules/forum.js') }}" type="text/javascript"></script>
    @yield('scripts')
    <script type="text/javascript">
        jQuery(window).on('load', function() {
            App.forum();
        });
    </script>
@endsection

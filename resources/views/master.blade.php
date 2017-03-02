<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <title>@yield('title') | {{ trans('messages.title') }}</title>

    <meta property="og:title" content="{{ trans('messages.title') }}" />
    <meta property="og:description" content="{{ trans('messages.site_description') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('img/pyro-life-banner.png') }}" />
    <meta property="fb:app_id " content="{{ config('services.facebook.client_id') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/nanoscroller.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/morris.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/whhg.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/whhg.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
    <!--[if lt IE 9]>
        <script src="{{ asset('js/html5shiv.min.js') }}"></script>
        <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="@yield('body-class')">

<div id="site-loader">
    <span class="vertical-middle">
        <i class="icon wh-loadingflowcw icon-spin icon-5x"></i>
    </span>
</div>

<div class="am-wrapper am-fixed-sidebar @yield('body-class')">
    @yield('pre-content')
    <div class="am-content @yield('content-class')">
        @yield('page-head')
        <div class="main-content padding-bottom-35">
            @yield('layout')
        </div>
        @include('partials.footer')
    </div>
    @yield('post-content')
</div>

<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.nanoscroller.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.masonry.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.multi-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/lib/chartjs/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/raphael/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/morrisjs/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/masonry.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/multiselect.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/licenses.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/forum.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/markdown.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/statlog.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.main.js') }}" type="text/javascript"></script>
@yield('scripts')
<script type="text/javascript">
    jQuery(window).on('load', function() {
        App.init();
        App.multiselect();
        App.dataTable();
        App.licenses();
        App.forum();
        App.markdown();
        App.statlog();

        App.masonry();
    });
</script>
@if(!Request::is('error'))
    <script type="text/javascript">
        if(top.location != window.location) {
            window.location = '/error';
        }
    </script>
@endif
</body>
</html>
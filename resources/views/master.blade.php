<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <title>{{ trans('messages.title') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/nanoscroller.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/whhg.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
    <!--[if lt IE 9]>
        <script src="{{ asset('js/html5shiv.min.js') }}"></script>
        <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="@yield('body-class')">

<div class="am-wrapper">
    @yield('pre-content')
    <div class="am-content">
        <div class="main-content">
            @yield('layout')
        </div>
    </div>
    @yield('post-content')
</div>

<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.nanoscroller.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.masonry.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/moment-timezone.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/lib/chartjs/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/lib/datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/masonry.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/modules/datatable.js') }}" type="text/javascript"></script>
@yield('scripts')
<script type="text/javascript">
    jQuery(window).on('load', function() {
        App.init();
        App.masonry();
        App.dataTable();
    });
</script>
</body>
</html>
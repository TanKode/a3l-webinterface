<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    <title>@yield('title') | Bambusfarm Community</title>

    <meta property="og:title" content="Bambusfarm | Arma 3 | Altis Life | Exile | Community" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('img/auth-background-2.jpg') }}" />

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />

    @foreach ($css as $path)
        <link rel="stylesheet" href="{{ asset($path) }}" />
    @endforeach

    <!--[if lt IE 9]>
        <script src="{{ asset('assets/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
        <script src="{{ asset('assets/vendor/media-match/media.match.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    @foreach ($js['head'] as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach

    <script type="text/javascript">
        Breakpoints();
    </script>
</head>
<body class="@yield('bodyClass')" data-datatables-defaults='{{ $dtDefaults }}' data-auto-menubar="false">
    {!! Form::hidden('csrf_token', Session::getToken()) !!}
    @yield("layout")

    @foreach ($js['foot'] as $path)
        <script src="{{ asset($path) }}"></script>
    @endforeach
</body>
</html>
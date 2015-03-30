<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arma 3 Altis Life Web-Tool</title>
    <link rel="shortcut icon" href="{{ url('/') }}/favicon.ico" type="image/x-icon">
    {{ HTML::style('css/superhero.min.css'); }}
    {{ HTML::style('css/whhg.css'); }}
    {{ HTML::style('css/styles.css'); }}

    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/bootstrap.jquery.min.js'); }}
    <script src="//code.highcharts.com/highcharts.js"></script>
    {{ HTML::script('js/highcharts.jquery.js'); }}

    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container-fluid">
        @if(Auth::check())
            {{ View::make('partials/header', array('level_label'=>$level_label)) }}
        @endif
        @if( isset($content) )
            {{ $content }}
        @endif
        {{ View::make('partials/footer') }}
    </div>

</body>
</html>
<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
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
    {{ HTML::style('css/superhero.min.css'); }}
    {{ HTML::style('css/whhg.css'); }}
    {{ HTML::style('css/styles.css'); }}

    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container-fluid">
        @if(Auth::check())
            {{ View::make('partials/sidebar', array('level_label'=>$level_label)) }}
        @endif
        @if( isset($content) )
            {{ $content }}
        @endif
    </div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.jquery.min.js"></script>
</body>
</html>
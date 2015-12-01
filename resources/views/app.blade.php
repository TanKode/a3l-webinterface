<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') | A3L WebInterface</title>

	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/whhg.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

	<!--[if lt IE 9]>
		<script src="{{ asset('/js/lib/html5shiv.min.js') }}"></script>
		<script src="{{ asset('/js/lib/respond.min.js') }}"></script>
	<![endif]-->
</head>
<body>

	<header>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ url('/') }}"><h1>A3L WebInterface</h1></a>
				</div>

				<div class="collapse navbar-collapse" id="main-navbar">
					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="{{ url('/auth/login') }}">Anmelden</a></li>
							<li><a href="{{ url('/auth/register') }}">Registrieren</a></li>
						@else
							<li><a href="{{ url('/') }}" @if(Request::is('/'))class="active"@endif><i class="icon-home"></i> Startseite</a></li>
							@if(Auth::User()->isAllowed('view_players'))
								<li class="dropdown">
									<a href="#" class="dropdown-toggle @if(Request::is('player/*') || Request::is('donator/*')) active @endif" data-toggle="dropdown" role="button" aria-expanded="false"><i class="icon-user"></i> Spieler <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ url('/player/list') }}" @if(Request::is('player/list'))class="active"@endif>alle Spieler</a></li>
										<li><a href="{{ url('donator/list') }}" @if(Request::is('donator/list'))class="active"@endif>Donator</a></li>
									</ul>
								</li>
							@endif
							@if(Auth::User()->isAllowed('view_vehicles'))
								<li><a href="{{ url('/vehicle/list') }}" @if(Request::is('vehicle/*'))class="active"@endif><i class="icon-automobile-car"></i> Fahrzeuge</a></li>
							@endif
							@if(Auth::User()->isAllowed('view_gangs'))
								<li><a href="{{ url('/gang/list') }}" @if(Request::is('gang/*'))class="active"@endif><i class="icon-groups-friends"></i> Gangs</a></li>
							@endif
							@if(Auth::User()->isAllowed('view_users'))
								<li><a href="{{ url('/user/list') }}" @if(Request::is('user/*'))class="active"@endif><i class="icon-supportalt"></i> Benutzer</a></li>
							@endif
							@if(Auth::User()->isAllowed('view_weblog'))
								<li><a href="{{ url('/weblog') }}" @if(Request::is('weblog'))class="active"@endif><i class="icon-dotlist"></i> Weblog</a></li>
							@endif
							@if(Auth::User()->isAllowed(['manage_roles', 'manage_permissions', 'manage_settings']))
								<li class="dropdown">
									<a href="#" class="dropdown-toggle @if(Request::is('role/*') || Request::is('permission/*') || Request::is('setting/*')) active @endif" data-toggle="dropdown" role="button" aria-expanded="false"><i class="icon-cog"></i> Adminbereich <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										@if(Auth::User()->isAllowed('view_database'))
											<li><a href="{{ url('/db/status') }}" @if(Request::is('db/*'))class="active"@endif>Datenbank</a></li>
										@endif
										@if(Auth::User()->isAllowed('manage_settings'))
											<li><a href="{{ url('/setting/list') }}" @if(Request::is('setting/*'))class="active"@endif>Einstellungen</a></li>
										@endif
										@if(Auth::User()->isAllowed('manage_roles'))
											<li><a href="{{ url('/role/list') }}" @if(Request::is('role/*'))class="active"@endif>Gruppen</a></li>
										@endif
										@if(Auth::User()->isAllowed('manage_permissions'))
											<li><a href="{{ url('/permission/list') }}" @if(Request::is('permission/*'))class="active"@endif>Berechtigungen</a></li>
										@endif
									</ul>
								</li>
							@endif
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
                                    @if(Auth::User()->player != null)
                                        <li><a href="{{ url('player/profile/'.Auth::User()->player->uid) }}">Profil</a></li>
                                    @endif
									<li><a href="{{ url('/auth/logout') }}">Abmelden</a></li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>
		<div class="well">
			<h2 class="no-spaces">@yield('title')</h2>
		</div>
	</header>

	<section class="container-fluid">
		@if(count(\Setting::get('broadcast')) > 0)
			<div class="alert alert-warning">
				<strong>@if(count(\Setting::get('broadcast')) > 1) Meldungen @else Meldung @endif</strong>
				<ul>
					@foreach(\Setting::get('broadcast') as $broadcast)
						<li>{{ $broadcast }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		@yield('content')
	</section>

	<footer class="well clearfix">
		<span class="pull-left">
			Arma 3 Altis Life WebInterface v{{ \Config::get('a3lwebinterface.version') }} |
            developed by <a href="https://github.com/Gummibeer" target="_blank">Gummibeer</a> &copy; 2015
		</span>

		<a href="https://www.paypal.me/gummibeer/5" target="_blank" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip" data-title="Paypal-Gebühren: 1,2% + 0,35€"><i class="icon-paypal"></i> Weiterentwicklung unterstützen</a>
	</footer>

	<!-- Scripts -->
	<script src="{{ asset('/js/lib/jquery.min.js') }}"></script>
	<script src="{{ asset('/js/lib/jquery.bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/lib/jquery.datatables.min.js') }}"></script>
	<script src="{{ asset('/js/lib/jquery.datatables.fixedheader.js') }}"></script>
    <script src="{{ asset('/js/lib/jquery.masonry.min.js') }}"></script>
	<script src="{{ asset('/js/lib/chart.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.functions.js') }}"></script>
</body>
</html>

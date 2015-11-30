@extends('app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
	@if(Auth::User()->isAllowed('view_system') && \Setting::get('system.show', false))
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading"><h3 class="panel-title">Systeminformationen</h3></div>
				<div class="panel-body">
					<ul class="list-inline">
						<li><span class="label label-default">{{ \Setting::get('system.os') }}</span></li>
						<li><span class="label label-danger">CPU: {{ \Setting::get('system.cpu') }}</span></li>
						<li><span class="label label-warning">RAM: {{ \Setting::get('system.ram') }}</span></li>
                        @foreach(\Setting::get('system.hdd') as $id => $hdd)
                            <li><span class="label label-success">HDD-{{ $id }}: {{ $hdd }}</span></li>
                        @endforeach
					</ul>

					<strong>Auslastungsverlauf in Prozent</strong>
					<div>
						<canvas id="server-cpu-chart" data-load="{{ \A3LWebInterface\Http\Controllers\SystemController::getLastLoads() }}"></canvas>
					</div>
				</div>
			</div>
		</div>
    @endif
    @if(Auth::User()->player != null)
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading"><h3 class="panel-title">Profil</h3></div>
                <ul class="list-group">
                    <li class="list-group-item">
                        Spieler-ID
                        <span class="badge">{{ Auth::User()->player->playerid }}</span>
                    </li>
                    <li class="list-group-item">
                        Name
                        <a href="{{ url('player/profile/'.Auth::User()->player->uid) }}" class="badge">{{ Auth::User()->player->name }}</a>
                    </li>
                    <li class="list-group-item">
                        Geld
                        <span class="badge">{{ \A3LWebInterface\Helper\Formatter::money(Auth::User()->player->cash + Auth::User()->player->bankacc) }}</span>
                    </li>
                    @if(count(Auth::User()->player->gang()) == 1)
                        <li class="list-group-item">
                            Gang
                            <div class="list-group-item-text">
                                <ul class="list-inline">
                                    <li><span class="label label-default">{{ Auth::User()->player->gang()->name }}</span></li>
                                    <li><span class="label label-default">@if(Auth::User()->player->isGangOwner()) Gründer @else Mitglied @endif</span></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if(Auth::User()->player->civVehicles->count() > 0)
                        <li class="list-group-item">
                            Civ Fahrzeuge
                            <span class="badge">{{ Auth::User()->player->civVehicles->count() }}</span>
                            <div class="list-group-item-text">
                                <ul class="list-inline">
                                    @foreach(Auth::User()->player->civVehicles as $vehicle)
                                        <li><span class="label label-default">{{ Setting::get('vehicle.'.$vehicle->classname, $vehicle->classname) }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if(Auth::User()->player->copVehicles->count() > 0)
                        <li class="list-group-item">
                            Cop Fahrzeuge
                            <span class="badge">{{ Auth::User()->player->copVehicles->count() }}</span>
                            <div class="list-group-item-text">
                                <ul class="list-inline">
                                    @foreach(Auth::User()->player->copVehicles as $vehicle)
                                        <li><span class="label label-default">{{ Setting::get('vehicle.'.$vehicle->classname, $vehicle->classname) }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if(Auth::User()->player->medVehicles->count() > 0)
                        <li class="list-group-item">
                            Med Fahrzeuge
                            <span class="badge">{{ Auth::User()->player->medVehicles->count() }}</span>
                            <div class="list-group-item-text">
                                <ul class="list-inline">
                                    @foreach(Auth::User()->player->medVehicles as $vehicle)
                                        <li><span class="label label-default">{{ Setting::get('vehicle.'.$vehicle->classname, $vehicle->classname) }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif
	@if(count(\Setting::get('info')) > 0)
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="panel panel-info">
			<div class="panel-heading"><h3 class="panel-title">Serveradressen</h3></div>
			<ul class="list-group">
				@foreach(\Setting::get('info') as $key => $info)
				<li class="list-group-item">
					{{ ucwords(implode(' ', explode('_', $key))) }}
					@if(strpos($info, 'http') === 0)
						<a href="{{ $info }}" class="badge" target="_blank">{{ preg_replace('#^http(s)?://#', '', $info) }}</a>
					@else
						<span class="badge">{{ $info }}</span>
					@endif
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
		<div class="panel panel-info">
			<div class="panel-heading"><h3 class="panel-title">Statistik</h3></div>
			<ul class="list-group">
				<li class="list-group-item">
					Benutzer
					@if(Auth::User()->isAllowed('view_users'))
						<a href="{{ url('/user/list') }}" class="badge">{{ \A3LWebInterface\User::count() }}</a>
					@else
						<span class="badge">{{ \A3LWebInterface\User::count() }}</span>
					@endif
				</li>
				<li class="list-group-item">
					Spieler
					@if(Auth::User()->isAllowed('view_players'))
						<a href="{{ url('/player/list') }}" class="badge">{{ \A3LWebInterface\Player::count() }}</a>
					@else
						<span class="badge">{{ \A3LWebInterface\Player::count() }}</span>
					@endif
				</li>
				<li class="list-group-item">
					Fahrzeuge
					@if(Auth::User()->isAllowed('view_vehicles'))
						<a href="{{ url('/vehicle/list') }}" class="badge">{{ \A3LWebInterface\Vehicle::count() }}</a>
					@else
						<span class="badge">{{ \A3LWebInterface\Vehicle::count() }}</span>
					@endif
				</li>
				<li class="list-group-item">
					Gangs
					@if(Auth::User()->isAllowed('view_gangs'))
						<a href="{{ url('/gang/list') }}" class="badge">{{ \A3LWebInterface\Gang::count() }}</a>
					@else
						<span class="badge">{{ \A3LWebInterface\Gang::count() }}</span>
					@endif
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection
@extends('app')

@section('title', 'Spieler Profil')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Spieler Profil</h3></div>

		<ul class="list-group">
			<li class="list-group-item">
				Spieler-ID
				<span class="badge">{{ Auth::User()->player->playerid }}</span>
			</li>
			<li class="list-group-item">
				Name
				<span class="badge">{{ Auth::User()->player->name }}</span>
			</li>
			<li class="list-group-item">
				Geld
				<span class="badge">{{ \A3LWebInterface\Libs\Formatter::money(Auth::User()->player->cash + Auth::User()->player->bankacc) }}</span>
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

			@if(count(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->civ_licenses)) > 0)
				<li class="list-group-item">
					Civ Lizenzen
					<div class="list-group-item-text">
						<ul class="list-inline">
							@foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->civ_licenses) as $licence)
								<li>
									<span class="licenses">
										@if($licence[1])
											<span class="label label-success">
										@else
											<span class="label label-default">
										@endif
										{{ \Setting::get('licence.'.$licence[0], $licence[0]) }}
										</span>
									</span>
								</li>
							@endforeach
						</ul>
					</div>
				</li>
			@endif
			@if(count(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->cop_licenses)) > 0)
				<li class="list-group-item">
					Cop Lizenzen
					<div class="list-group-item-text">
						<ul class="list-inline">
							@foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->cop_licenses) as $licence)
								<li>
									<span class="licenses">
										@if($licence[1])
											<span class="label label-success">
										@else
											<span class="label label-default">
										@endif
										{{ \Setting::get('licence.'.$licence[0], $licence[0]) }}
										</span>
									</span>
								</li>
							@endforeach
						</ul>
					</div>
				</li>
			@endif
			@if(count(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->med_licenses)) > 0)
				<li class="list-group-item">
					Med Lizenzen
					<div class="list-group-item-text">
						<ul class="list-inline">
							@foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->med_licenses) as $licence)
								<li>
									<span class="licenses">
										@if($licence[1])
											<span class="label label-success">
										@else
											<span class="label label-default">
										@endif
										{{ \Setting::get('licence.'.$licence[0], $licence[0]) }}
										</span>
									</span>
								</li>
							@endforeach
						</ul>
					</div>
				</li>
			@endif
		</ul>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Log-Verlauf</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover" data-order='[[ 0, "desc" ]]'>
			<thead>
			<tr>
				<th>Datum</th>
				<th>Bearbeiter</th>
				<th>Aktion</th>
				<th>Objekt</th>
				<th>Bemerkung</th>
			</tr>
			</thead>
			@foreach(\A3LWebInterface\Weblog::where('object_id', $player->uid)->where('table', 'players')->get() as $log)
				<tr>
					<td>{{ date('d.m.Y - H:i', strtotime($log->created_at)) }}</td>
					<td>{{ $log->editor_name }} ({{ $log->editor_id }})</td>
					<td>
						@if($log->type == 'DELETE')
							<span class="label label-danger">
						@elseif($log->type == 'UPDATE')
							<span class="label label-warning">
						@elseif($log->type == 'CREATE')
							<span class="label label-success">
						@endif
						{{ $log->type }}</span>
					</td>
					<td>{{ $log->object_name }} ({{ $log->object_id }})</td>
					<td>{{ $log->comment }}</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
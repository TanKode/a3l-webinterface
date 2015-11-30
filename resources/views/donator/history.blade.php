@extends('app')

@section('title', 'Donator-Verlauf')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Donator-Verlauf - {{ $player->name }} ({{ $player->playerid }})</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover" data-order='[[ 0, "desc" ]]'>
			<thead>
			<tr>
				<th>Datum</th>
				<th>Bearbeiter</th>
				<th>Aktion</th>
				<th>Spende</th>
				<th>Bemerkung</th>
			</tr>
			</thead>
			@foreach(\A3LWebInterface\Donatorhistory::where('player_id', $player->playerid)->get() as $log)
				<tr>
					<td>{{ date('d.m.Y - H:i', strtotime($log->created_at)) }}</td>
					<td>{{ $log->editor_name }} ({{ $log->editor_id }})</td>
					<td>
						@if($log->amount == 0)
							<span class="label label-danger">DELETE</span>
						@else
							<span class="label label-success">CREATE</span>
						@endif
					</td>
					<td>
						@if($log->amount != 0)
							{{ $log->amount }} € für {{ $log->duration }} Monate über {{ $log->method }}
						@endif
					</td>
					<td>{{ $log->comment }}</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
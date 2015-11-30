@extends('app')

@section('title', 'Weblog')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Weblog</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover" data-order='[[ 0, "desc" ]]'>
			<thead>
			<tr>
				<th>Datum</th>
				<th>Bearbeiter</th>
				<th>Aktion</th>
				<th>Typ</th>
				<th>Objekt</th>
				<th>Eigentümer</th>
				<th>Bemerkung</th>
			</tr>
			</thead>
			@foreach($weblogs as $log)
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
					<td>{{ $log->table }}</td>
					<td>{{ $log->object_name }} ({{ $log->object_id }})</td>
					<td>
						@if(!empty($log->player_id))
							{{ $log->player_name }} ({{ $log->player_id }})
						@else
							---
						@endif
					</td>
					<td>{{ $log->comment }}</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
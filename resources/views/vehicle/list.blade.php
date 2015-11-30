@extends('app')

@section('title', 'Fahrzeugliste')

@section('content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Fahrzeugliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Spieler-ID</th>
				<th>Seite</th>
				<th>Typ</th>
				<th>Name</th>
				<th></th>
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Vehicle::all() as $vehicle)
				<tr>
					<td>{{ $vehicle->id }}</td>
					<td>{{ $vehicle->pid }}</td>
					<td>{{ $vehicle->side }}</td>
					<td>{{ $vehicle->type }}</td>
					<td>{{ Setting::get('vehicle.'.$vehicle->classname, $vehicle->classname) }}</td>
					@if(Auth::User()->isAllowed('edit_vehicle') || Auth::User()->isAllowed('delete_vehicle'))
						<td>
							@if(Auth::User()->isAllowed('delete_vehicle'))
								{!! Form::open(array('route' => ['vehicle.delete', $vehicle->id], 'method' => 'post')) !!}
								<div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
									<input type="text" name="comment" class="form-control" placeholder="Begründung" style="max-width:300px"/>
									<span class="input-group-btn">
										<button type="submit" class="btn btn-danger">Fahrzeug löschen</button>
									</span>
								</div>
								{!! Form::close() !!}
							@endif
							@if(Auth::User()->isAllowed('edit_vehicle'))
								<a href="{{ url('/vehicle/edit/'.$vehicle->id) }}" class="btn btn-sm btn-warning pull-right">Fahrzeug bearbeiten</a>
							@endif
						</td>
					@endif
				</tr>
			@endforeach
		</table>
	</div>
@endsection
@extends('app')

@section('title', 'Fahrzeug bearbeiten')

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

	<div class="panel panel-warning">
		<div class="panel-heading"><h3 class="panel-title">Fahrzeug bearbeiten</h3></div>
		{!! Form::model($vehicle, array('route' => ['vehicle.update', $vehicle->id], 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-2">
				<div class="input-group">
					{!! Form::label('side', 'Seite', array('class' => 'input-group-addon')) !!}
					{!! Form::select('side',array_combine(DB::table('vehicles')->groupBy('side')->lists('side'),DB::table('vehicles')->groupBy('side')->lists('side')),null,array('class'=>'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
					{!! Form::label('type', 'Typ', array('class' => 'input-group-addon')) !!}
					{!! Form::select('type',array_combine(DB::table('vehicles')->groupBy('type')->lists('type'),DB::table('vehicles')->groupBy('type')->lists('type')),null,array('class'=>'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
					{!! Form::label('color', 'Farbe', array('class' => 'input-group-addon')) !!}
					{!! Form::select('color',array_combine(DB::table('vehicles')->where('classname', $vehicle->classname)->groupBy('color')->lists('color'),DB::table('vehicles')->where('classname', $vehicle->classname)->groupBy('color')->lists('color')),null,array('class'=>'form-control')) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					{!! Form::label('plate', 'Kennzeichen', array('class' => 'input-group-addon')) !!}
					{!! Form::text('plate', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('active') !!} aktiv
					</label>
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('alive') !!} ganz
					</label>
				</div>
			</div>

			<div class="col-md-6">
				<div class="input-group">
					{!! Form::label('pid', 'Spieler-ID', array('class' => 'input-group-addon')) !!}
					{!! Form::text('pid', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="input-group">
					{!! Form::label('classname', 'Klassenname', array('class' => 'input-group-addon')) !!}
					{!! Form::text('classname', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-10">
				<div class="input-group">
					{!! Form::label('comment', 'Begründung', array('class' => 'input-group-addon')) !!}
					{!! Form::text('comment', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-1">
				<a href="{{ url('/vehicle/list') }}" class="btn btn-block btn-default">abbrechen</a>
			</div>
			<div class="col-md-1">
				{!! Form::submit('speichern', array('class' => 'btn btn-danger btn-block')) !!}
			</div>
		</div>
		{!! Form::close() !!}
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
			@foreach(\A3LWebInterface\Weblog::where('object_id', $vehicle->id)->where('table', 'vehicles')->get() as $log)
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
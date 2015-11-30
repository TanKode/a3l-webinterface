@extends('app')

@section('title', 'Berechtigungsliste')

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
		<div class="panel-heading"><h3 class="panel-title">Berechtigung hinzufügen</h3></div>
		{!! Form::open(array('route' => 'permission.add', 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-6">
				<div class="input-group">
					{!! Form::label('name', 'Schlüssel', array('class' => 'input-group-addon')) !!}
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="input-group">
				{!! Form::label('display_name', 'Name', array('class' => 'input-group-addon')) !!}
				{!! Form::text('display_name', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="input-group">
				{!! Form::label('description', 'Beschreibung', array('class' => 'input-group-addon')) !!}
				{!! Form::text('description', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-10">
				<div class="input-group">
					{!! Form::label('comment', 'Begründung', array('class' => 'input-group-addon')) !!}
					{!! Form::text('comment', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				{!! Form::submit('speichern', array('class' => 'btn btn-danger btn-block')) !!}
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Berechtigungsliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover" data-order='[[ 1, "asc" ]]'>
			<thead>
			<tr>
				<th>#</th>
				<th>Schlüssel</th>
				<th>Name</th>
				<th>Beschreibung</th>
				<th></th>
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Permission::orderBy('name')->get() as $permission)
				<tr>
					<td>{{ $permission->id }}</td>
					<td>{{ $permission->name }}</td>
					<td>{{ $permission->display_name }}</td>
					<td>{{ $permission->description }}</td>
					<td><a href="{{ url('/permission/edit/'.$permission->id) }}" class="btn btn-sm btn-warning pull-right">Berechtigung bearbeiten</a></td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
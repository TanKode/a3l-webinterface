@extends('app')

@section('title', 'Gruppenliste')

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
		<div class="panel-heading"><h3 class="panel-title">Gruppe hinzufügen</h3></div>
		{!! Form::open(array('route' => 'role.add', 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::select('permissions',array_combine(\A3LWebInterface\Permission::lists('id'),\A3LWebInterface\Permission::lists('name')),null,array('name'=>'permissions[]','multiple'=>'multiple','class'=>'form-control','style'=>'height:132px')) !!}
				</div>
			</div>
			<div class="col-md-5">
				<div class="input-group">
					{!! Form::label('name', 'Schlüssel', array('class' => 'input-group-addon')) !!}
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-5">
				<div class="input-group">
					{!! Form::label('display_name', 'Name', array('class' => 'input-group-addon')) !!}
					{!! Form::text('display_name', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-10">
				<div class="input-group">
					{!! Form::label('description', 'Beschreibung', array('class' => 'input-group-addon')) !!}
					{!! Form::text('description', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-8">
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
		<div class="panel-heading"><h3 class="panel-title">Gruppenliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Schlüssel</th>
				<th>Name</th>
				<th>Beschreibung</th>
				<th>Berechtigungen</th>
				<th></th>
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Role::all() as $role)
				<tr>
					<td>{{ $role->id }}</td>
					<td>{{ $role->name }}</td>
					<td>{{ $role->display_name }}</td>
					<td>{{ $role->description }}</td>
					<td>
						<ul class="list-inline">
							@if($role->name == 'super_admin')
								<li><span class="label label-danger">kann alles</span></li>
							@endif
							@foreach($role->perms as $permission)
								<li><span class="label label-default">{{ $permission->name }}</span></li>
							@endforeach
						</ul>
					</td>
					<td><a href="{{ url('/role/edit/'.$role->id) }}" class="btn btn-sm btn-warning pull-right">Gruppe bearbeiten</a></td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
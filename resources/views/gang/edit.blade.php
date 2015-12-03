@extends('app')

@section('title', 'Gang bearbeiten')

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
		<div class="panel-heading"><h3 class="panel-title">Gang bearbeiten</h3></div>
		{!! Form::model($gang, array('route' => ['gang.update', $gang->id], 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('name', 'Name', array('class' => 'input-group-addon')) !!}
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('owner', 'Gründer', array('class' => 'input-group-addon')) !!}
					{!! Form::text('owner', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('bank', 'Bank', array('class' => 'input-group-addon')) !!}
					{!! Form::text('bank', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
					{!! Form::label('maxmembers', 'Größe', array('class' => 'input-group-addon')) !!}
					{!! Form::text('maxmembers', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('active') !!} aktiv
					</label>
				</div>
			</div>
			<div class="col-md-12">
				<ul class="list-inline">
					<?php
					$members = array_unique(\A3LWebInterface\Libs\Formatter::decodeDBArray($gang->members));
					?>
					@foreach($members as $member)
						@if(is_numeric($member))
						<li>
							<label for="member-{{ $member }}" class="licenses">
								<span class="label label-success">
									{{ $member }}
								</span>
								<input type="checkbox" name="members['{{ $member }}']" class="licenses hidden" id="member-{{ $member }}" checked />
							</label>
						</li>
						@endif
					@endforeach
				</ul>
			</div>

			<div class="col-md-10">
				<div class="input-group">
					{!! Form::label('comment', 'Begründung', array('class' => 'input-group-addon')) !!}
					{!! Form::text('comment', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-1">
				<a href="{{ url('/gang/list') }}" class="btn btn-block btn-default">abbrechen</a>
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
			@foreach(\A3LWebInterface\Weblog::where('object_id', $gang->id)->where('table', 'gangs')->get() as $log)
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
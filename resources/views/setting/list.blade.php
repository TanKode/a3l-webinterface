@extends('app')

@section('title', 'Einstellungen')

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
		<div class="panel-heading"><h3 class="panel-title">Einstellung hinzufügen</h3></div>
		{!! Form::open(array('route' => 'setting.add', 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-5">
				<div class="input-group">
					{!! Form::label('key', 'Schlüssel', array('class' => 'input-group-addon')) !!}
					{!! Form::text('key', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-5">
				<div class="input-group">
					{!! Form::label('value', 'Wert', array('class' => 'input-group-addon')) !!}
					{!! Form::text('value', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				{!! Form::submit('speichern', array('class' => 'btn btn-danger btn-block')) !!}
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Einstellungen</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>Schlüssel</th>
				<th>Wert</th>
				<th></th>
			</tr>
			</thead>
			@foreach(Setting::all() as $key => $setting)
				@if(is_array($setting))
					@foreach($setting as $child_key => $value)
                        @if(is_array($value))
                            @foreach($value as $subchild_key => $subvalue)
                            <tr>
                                <td>{{ $key.'.'.$child_key.'.'.$subchild_key }}</td>
                                <td>{{ $subvalue }}</td>
                                <td>
                                    {!! Form::open(array('route' => ['setting.update', $key.'.'.$child_key.'.'.$subchild_key], 'method' => 'post')) !!}
                                    <div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
                                        <input type="text" name="value" value="{{ $subvalue }}" class="form-control" placeholder="Wert" style="max-width:300px"/>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning">Einstellung speichern</button>
                                    </span>
                                    </div>
                                    {!! Form::close() !!}
                                    <a href="{{ url('/setting/delete/'.$key.'.'.$child_key.'.'.$subchild_key) }}" class="btn btn-sm btn-danger pull-right">Einstellung löschen</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $key.'.'.$child_key }}</td>
                                <td>{{ $value }}</td>
                                <td>
                                    {!! Form::open(array('route' => ['setting.update', $key.'.'.$child_key], 'method' => 'post')) !!}
                                    <div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
                                        <input type="text" name="value" value="{{ $value }}" class="form-control" placeholder="Wert" style="max-width:300px"/>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning">Einstellung speichern</button>
                                    </span>
                                    </div>
                                    {!! Form::close() !!}
                                    <a href="{{ url('/setting/delete/'.$key.'.'.$child_key) }}" class="btn btn-sm btn-danger pull-right">Einstellung löschen</a>
                                </td>
                            </tr>
                        @endif
					@endforeach
				@else
					<tr>
						<td>{{ $key }}</td>
						<td>{{ $setting }}</td>
						<td>
							{!! Form::open(array('route' => ['setting.update', $key], 'method' => 'post')) !!}
							<div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
								<input type="text" name="value" value="{{ $setting }}" class="form-control" placeholder="Wert" style="max-width:300px"/>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-warning">Einstellung speichern</button>
								</span>
							</div>
							{!! Form::close() !!}
							<a href="{{ url('/setting/delete/'.$key) }}" class="btn btn-sm btn-danger pull-right">Einstellung löschen</a>
						</td>
					</tr>
				@endif
			@endforeach
		</table>
	</div>
@endsection
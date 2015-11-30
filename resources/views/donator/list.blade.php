@extends('app')

@section('title', 'Donatorliste')

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
		<div class="panel-heading"><h3 class="panel-title">Donator hinzufügen</h3></div>
		{!! Form::open(array('route' => 'donator.add', 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="input-group">
					{!! Form::label('player_id', 'Spieler-ID', array('class' => 'input-group-addon')) !!}
					{!! Form::text('player_id', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('date', 'Datum', array('class' => 'input-group-addon')) !!}
					{!! Form::input('date', 'date', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('amount', 'Betrag', array('class' => 'input-group-addon')) !!}
					{!! Form::input('number', 'amount', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
					{!! Form::label('duration', 'Monate', array('class' => 'input-group-addon')) !!}
					{!! Form::input('number', 'duration', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					{!! Form::label('method', 'Zahlungsmethode', array('class' => 'input-group-addon')) !!}
					{!! Form::text('method', null, array('class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-7">
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
		<div class="panel-heading"><h3 class="panel-title">Donatorliste</h3></div>
		@include('forms.datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Spieler-ID</th>
				<th>Name</th>
				<th></th>
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Player::where('donatorlvl', '>', 0)->get() as $player)
				<tr>
					<td>{{ $player->uid }}</td>
					<td>{{ $player->playerid }}</td>
					<td>{{ $player->name }}</td>
					<td>
						@if(Auth::User()->isAllowed('delete_donator'))
							{!! Form::open(array('route' => ['donator.delete', $player->uid], 'method' => 'post')) !!}
							<div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
								<input type="text" name="comment" class="form-control" placeholder="Begründung" style="max-width:300px"/>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger">Donator löschen</button>
								</span>
							</div>
							{!! Form::close() !!}
						@endif
						<a href="{{ url('/donator/history/'.$player->uid) }}" class="btn btn-sm btn-warning pull-right">Donator Verlauf</a>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
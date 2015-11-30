@extends('app')

@section('title', 'Benutzerliste')

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
		<div class="panel-heading"><h3 class="panel-title">Benutzerliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Rolle</th>
				<th>Spieler-ID</th>
				<th>Name</th>
				<th>E-Mail</th>
				@if(Auth::User()->isAllowed('edit_user') || Auth::User()->isAllowed('delete_user'))
					<th></th>
				@endif
			</tr>
			</thead>
			@foreach( \A3LWebInterface\User::all() as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->roles[0]->display_name }}</td>
					<td>{{ $user->player_id }}</td>
					<td>{{ $user->name }}</td>
					<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
					@if(Auth::User()->isAllowed('edit_user') || Auth::User()->isAllowed('delete_user'))
					<td>
						@if(Auth::User()->isAllowed('delete_user'))
							{!! Form::open(array('route' => ['user.delete', $user->id], 'method' => 'post')) !!}
							<div class="input-group input-group-sm pull-right" style="max-width:400px;margin:0;margin-left:15px;">
								<input type="text" name="comment" class="form-control" placeholder="Begründung" style="max-width:300px"/>
									<span class="input-group-btn">
										<button type="submit" class="btn btn-danger">Benutzer löschen</button>
									</span>
							</div>
							{!! Form::close() !!}
						@endif
						@if(Auth::User()->isAllowed('edit_user'))
							<a href="{{ url('/user/edit/'.$user->id) }}" class="btn btn-sm btn-warning pull-right">Benutzer bearbeiten</a>
						@endif
					</td>
					@endif
				</tr>
			@endforeach
		</table>
	</div>
@endsection
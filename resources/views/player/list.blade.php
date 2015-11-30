@extends('app')

@section('title', 'Spielerliste')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Spielerliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Spieler-ID</th>
				<th>Name</th>
				@if(Auth::User()->isAllowed('edit_player') || Auth::User()->isAllowed('view_donators'))
					<th></th>
				@endif
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Player::all() as $player)
				<tr>
					<td>{{ $player->uid }}</td>
					<td>{{ $player->playerid }}</td>
					<td>{{ $player->name }}</td>
					@if(Auth::User()->isAllowed('edit_player') || Auth::User()->isAllowed('view_donators'))
						<td>
						@if(Auth::User()->isAllowed('edit_player'))
							<a href="{{ url('/player/edit/'.$player->uid) }}" class="btn btn-sm btn-warning pull-right">Spieler bearbeiten</a>
						@endif
						@if(Auth::User()->isAllowed('view_donators'))
							<a href="{{ url('/donator/history/'.$player->uid) }}" class="btn btn-sm btn-warning pull-right">Donator Verlauf</a>
						@endif
						</td>
					@endif
				</tr>
			@endforeach
		</table>
	</div>
@endsection
@extends('app')

@section('title', 'Gangliste')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Gangliste</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>Gründer</th>
				<th>Name</th>
				@if(Auth::User()->isAllowed('edit_gang'))
					<th></th>
				@endif
			</tr>
			</thead>
			@foreach( \A3LWebInterface\Gang::all() as $gang)
				<tr>
					<td>{{ $gang->id }}</td>
					<td>{{ $gang->owner }}</td>
					<td>{{ $gang->name }}</td>
					@if(Auth::User()->isAllowed('edit_gang'))
						<td><a href="{{ url('/gang/edit/'.$gang->id) }}" class="btn btn-sm btn-warning pull-right">Gang bearbeiten</a></td>
					@endif
				</tr>
			@endforeach
		</table>
	</div>
@endsection
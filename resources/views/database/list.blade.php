@extends('app')

@section('title', 'Datenbank')

@section('content')

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Datenbank Größe</h3></div>
		<table class="table table-hover dt-exclude">
			<thead>
			<tr>
				<th>Tabelle</th>
				<th>Datensätze</th>
				<th>Speichergröße</th>
			</tr>
			</thead>
			<?php
			$rows = 0;
			$size = 0;
			?>
			@foreach( DB::select('SELECT table_name, table_rows, Round((data_length + index_length) / 1024, 1) "table_size" FROM information_schema.tables WHERE table_schema = "' . \Config::get('database.connections.mysql.database') . '";') as $table )
				<tr>
					<td>{{ $table->table_name }}</td>
					<td>{{ $table->table_rows }} Einträge</td>
					<?php $rows += $table->table_rows; ?>
					<td>{{ $table->table_size }} KB</td>
					<?php $size += $table->table_size; ?>
				</tr>
			@endforeach
			<tfoot>
			<tr>
				<th>gesamt</td>
				<th>{{ $rows }} Einträge</td>
				<th>{{ number_format($size / 1024, 2) }} MB</td>
			</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Datenbank Backups</h3></div>
		<div class="row">
			<div class="col-md-10">
				@include('forms/datatables_search')
			</div>
			<div class="col-md-2">
				<div class="panel-body">
					<a href="{{ url('db/backup') }}" class="btn btn-danger btn-block" target="_blank">Backup erstellen</a>
				</div>
			</div>
		</div>
		<table class="table table-hover" data-order='[[ 1, "desc" ],[ 2, "desc" ]]'>
			<thead>
			<tr>
				<th>Datenbank</th>
				<th>Datum</th>
				<th>Uhrzeit</th>
                <th>Größe</th>
				<th></th>
			</tr>
			</thead>
			@foreach( \Storage::disk('local')->allFiles('backups') as $backup )
				<tr>
					<td>{{ explode('_-_', $backup)[1] }}</td>
					<td>{{ explode('_-_', $backup)[3] }}</td>
					<td>{{ str_replace('.sql', '', explode('_-_', $backup)[4]) }}</td>
                    <td>{{ number_format(\Storage::size($backup) / 1024 / 1024, 2) . ' MB' }}</td>
					<td>
                        <a href="{{ url('db/delete/'.str_replace('backups'.DIRECTORY_SEPARATOR, '', $backup)) }}" class="btn btn-sm btn-danger pull-right">Backup löschen</a>
                        <a href="{{ url('db/download/'.str_replace('backups'.DIRECTORY_SEPARATOR, '', $backup)) }}" class="btn btn-sm btn-warning pull-right">Backup herunterladen</a>
                    </td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
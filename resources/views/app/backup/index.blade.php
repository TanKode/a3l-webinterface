@extends('app')

@section('title', 'Backup Übersicht')

@section('content')
    {!! Filter::render([
        Form::text('database', null, [
            'label' => 'Datenbank',
            'id' => 'databaseFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
        Form::text('date', null, [
            'label' => 'Datum',
            'id' => 'dateFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
    ]) !!}

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th class="german" data-search-key="database">Datenbank</th>
                        <th data-search-key="date">Datum</th>
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($backups as $backup)
                        <tr>
                            <td>{{ $backup['database'] }}</td>
                            <td>{{ $backup['date'] }}</td>
                            <td><a href="{{ url('app/backup/download/'.$backup['file']) }}" class="btn btn-sm btn-warning">download</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
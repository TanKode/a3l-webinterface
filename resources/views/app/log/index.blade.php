@extends('app')

@section('title', 'Log Übersicht')

@section('content')
    {!! Filter::render([
        Form::text('level', null, [
            'label' => 'Level',
            'id' => 'levelFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
        Form::text('log', null, [
            'label' => 'Log',
            'id' => 'logFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
        Form::text('date', null, [
            'label' => 'Zeitpunkt',
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
                        <th class="german" data-search-key="level">Level</th>
                        <th class="german" data-search-key="log">Log</th>
                        <th data-search-key="date">Zeitpunkt</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ array_get(\App\Log::$LEVEL, $log->level) }}</td>
                            <td>{{ $log->message }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@extends('app')

@section('title', 'Altis Life Fahrzeuge')

@section('content')
    {!! Filter::render([
        Form::text('type', null, [
            'label' => 'Typ',
            'id' => 'typeFilter',
            'data-typeahead' => false,
            'data-default' => '',
        ]),
        Form::text('classname', null, [
            'label' => 'Serie',
            'id' => 'classnameFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
        Form::text('side', null, [
            'label' => 'Seite',
            'id' => 'sideFilter',
            'data-typeahead' => false,
            'data-default' => '',
        ]),
        Form::text('owner', null, [
            'label' => 'Besitzer',
            'id' => 'ownerFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
    ]) !!}

    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </header>
        <section class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th class="german" data-search-key="type">Typ</th>
                        <th class="german" data-search-key="classname">Serie</th>
                        <th class="german" data-search-key="side">Seite</th>
                        <th class="german" data-search-key="owner">Besitzer</th>
                        <th class="german">ganz</th>
                        <th class="german">ausgeparkt</th>
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->type }}</td>
                            <td>{{ trans('vehicles.'.$vehicle->classname) }}</td>
                            <td>{{ $vehicle->side }}</td>
                            <td>{{ $vehicle->owner->name }} #{{ $vehicle->owner->playerid }}</td>
                            <td>{{ $vehicle->alive ? 'ja' : 'nein' }}</td>
                            <td>{{ $vehicle->active ? 'ja' : 'nein' }}</td>
                            <td>
                                <a href="{{ url('app/a3l/vehicle/edit/'.$vehicle->id) }}"><i class="icon fa-pencil text-warning"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
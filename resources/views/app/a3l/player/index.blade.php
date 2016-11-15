@extends('app')

@section('title', 'Altis Life Spieler')

@section('content')
    {!! Filter::render([
        Form::text('playerId', null, [
            'label' => 'Spieler-ID',
            'id' => 'playerIdFilter',
            'data-typeahead' => true,
            'data-default' => '',
        ]),
        Form::text('playerName', null, [
            'label' => 'Name',
            'id' => 'playerNameFilter',
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
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable" data-order='[[ 1, "asc" ]]'>
                    <thead>
                    <tr>
                        <th data-search-key="playerId">ID</th>
                        <th class="german" data-search-key="playerName">Name</th>
                        <th class="money">Bargeld</th>
                        <th class="money">Bank</th>
                        <th>Karma</th>
                        <th>Polizist</th>
                        <th>Medic</th>
                        <th>Admin</th>
                        <th>Donator</th>
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>{{ $player->playerid }}</td>
                            <td>{{ $player->name }}</td>
                            <td class="text-right">{{ $player->cash_m }}</td>
                            <td class="text-right">{{ $player->bankacc_m }}</td>
                            <td class="text-right">{{ $player->Karma }}</td>
                            <td>{{ $player->coplevel }}</td>
                            <td>{{ $player->mediclevel }}</td>
                            <td>{{ $player->adminlevel }}</td>
                            <td>{{ $player->donatorlvl }}</td>
                            <td>
                                <a href="{{ url('app/a3l/player/edit/'.$player->uid) }}"><i class="icon fa-pencil text-warning"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
@extends('app')

@section('title', 'Exile Accounts')

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
                        <th class="money">Pop Tabs</th>
                        <th class="money">Respekt</th>
                        <th>Kills</th>
                        <th>Deaths</th>
                        <th>Kills / Deaths</th>
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->uid }}</td>
                            <td>{{ $account->name }}</td>
                            <td class="text-right">{{ $account->money }}</td>
                            <td class="text-right">{{ $account->score }}</td>
                            <td class="text-right">{{ $account->kills }}</td>
                            <td class="text-right">{{ $account->deaths }}</td>
                            <td class="text-right">{{ format_float($account->kd) }}</td>
                            <td>
                                <a href="{{ url('app/a3e/account/edit/'.$account->uid) }}"><i class="icon fa-pencil text-warning"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
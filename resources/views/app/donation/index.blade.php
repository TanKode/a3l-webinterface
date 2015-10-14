@extends('app')

@section('title', 'Spenden Übersicht')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">neue Spende</h3>
            <div class="panel-actions">
                <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => 'app/donation/store', 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::selectpicker('donator_id', \App\User::getSelectArray('id', 'username'), null, ['label' => 'Spender', 'search' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::text('euro_amount', null, ['label' => 'Spendenbetrag']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::number('bamboo_amount', null, ['label' => 'Bamboo-Coins']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::text('method', null, ['label' => 'Methode']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::text('description', null, ['label' => 'Begründung']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable" data-order='[[ 7, "desc" ]]'>
                    <thead>
                    <tr>
                        <th class="german">#</th>
                        <th class="german">Spender</th>
                        <th class="german">Bearbeiter</th>
                        <th>Spendenbetrag</th>
                        <th>Bamboo-Coins</th>
                        <th class="german">Methode</th>
                        <th class="german">Begründung</th>
                        <th>Datum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->id }}</td>
                            <td>{{ $donation->donator->username }}</td>
                            <td>{{ $donation->booker->username }}</td>
                            <td>{{ $donation->euro_amount }}</td>
                            <td>{{ $donation->bamboo_amount }}</td>
                            <td>{{ $donation->method }}</td>
                            <td>{{ $donation->description }}</td>
                            <td>{{ $donation->created_at->setTimezone('Europe/Berlin')->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
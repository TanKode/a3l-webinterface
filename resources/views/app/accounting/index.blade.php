@extends('app')

@section('title', 'Buchungs Übersicht')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">neue Buchung</h3>
            <div class="panel-actions">
                <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => 'app/accounting/store', 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::text('amount', null, ['label' => 'Betrag']) !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('description', null, ['label' => 'Beschreibung']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                @yield('title')
                <span class="pull-right @if($accounting_sum < 0) text-danger @else text-success @endif">
                    {{ format_money($accounting_sum) }}
                </span>
            </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable" data-order='[[ 4, "desc" ]]'>
                    <thead>
                    <tr>
                        <th class="german">#</th>
                        <th class="german">Bearbeiter</th>
                        <th>Betrag</th>
                        <th class="german">Beschreibung</th>
                        <th>Datum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accountings as $accounting)
                        <tr>
                            <td>{{ $accounting->id }}</td>
                            <td>{{ $accounting->booker->username }}</td>
                            <td class="@if($accounting->amount < 0) text-danger @else text-success @endif">{{ $accounting->amount }}</td>
                            <td>{{ $accounting->description }}</td>
                            <td>{{ $accounting->created_at->setTimezone('Europe/Berlin')->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@extends('app')

@section('title', $player->name.'\'s Spieler-Profil')

@section('content')
{!! Form::model($player, ['url' => 'app/a3l/player/edit/'.$player->uid]) !!}
@if(\Auth::User()->can('manage-basic', \App\A3L\Player::class))
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">{{ $player->name }} Basics</h3>
        </header>
        <section class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    {!! Form::number('cash', null, ['label' => 'Bargeld']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('bankacc', null, ['label' => 'Bank']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('Karma', null, ['label' => 'Karma']) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    {!! Form::number('coplevel', null, ['label' => 'Polizist']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('mediclevel', null, ['label' => 'Medic']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('donatorlvl', null, ['label' => 'Donator']) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('adminlevel', null, ['label' => 'Admin']) !!}
                </div>
            </div>
        </section>
    </div>
@endif
@if(\Auth::User()->can('manage-civ', \App\A3L\Player::class))
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">Zivilist</h3>
        </header>
        <section class="panel-body">
            <h4>Ausrüstung</h4>
            {{ dump($player->civ_gear['gear']) }}
            <h4>Inventar</h4>
            <ul class="list-inline">
            @foreach(array_count_values($player->civ_gear['items']) as $item => $count)
                <li class="label label-dark">{{ $count }} * {{ trans('items.'.$item) }}</li>
            @endforeach
            </ul>
            <h4>Lizenzen</h4>
            <ul class="list-inline">
            @foreach($player->civ_licenses as $key => $value)
                <li>
                    <label class="label-license">
                        {!! Form::hidden('licenses['.$key.']', $value) !!}
                        {!! Form::checkbox('licenses['.$key.']', 1, $value, ['class' => 'hidden']) !!}
                        <span class="label label-dark">{{ trans('licenses.'.$key) }}</span>
                    </label>
                </li>
            @endforeach
            </ul>
        </section>
    </div>
@endif
@if(\Auth::User()->can('manage-cop', \App\A3L\Player::class) && $player->coplevel > 0)
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">Polizist</h3>
        </header>
        <section class="panel-body">

        </section>
    </div>
@endif
@if(\Auth::User()->can('manage-med', \App\A3L\Player::class) && $player->mediclevel > 0)
    <div class="panel">
        <header class="panel-heading">
            <h3 class="panel-title">Medic</h3>
        </header>
        <section class="panel-body">

        </section>
    </div>
@endif
{!! Form::close() !!}
@endsection
<?php
/**
 * ide: PhpStorm
 * Author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 1.3
 */
?>


<h2>Spieler @if($database == 'arma3life')<span class="label label-danger">LIVE</span>@endif</h2>

@if(Session::has('message') && Session::has('type'))
    <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('message') }}
    </div>
@endif

{{ $donators->links() }}

<div class="table table-hover">
    <div class="thead">
        <strong>ID</strong>
        <strong>Spieler-ID</strong>
        <strong>Name</strong>
        <strong>erster Login</strong>
        <strong>letztes Update</strong>
        <strong>Donator-Level</strong>
        <strong>Donator-Betrag</strong>
        <strong>Donator-Dauer</strong>
        <strong>Donator seit</strong>
        <strong>Donator bis</strong>
        <strong>Begründung</strong>
        <strong></strong>
    </div>

    {{ Form::open(array('url'=>'donators/add')) }}
        <span>#</span>
        <span>
            {{ Form::text('playerid') }}
        </span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span>
            {{ Form::number('donatoramount', null, array('placeholder'=>'Betrag')) }}
        </span>
        <span>
            {{ Form::select('donatorduration', array('1'=>'1 Monat', '2'=>'2 Monate', '3'=>'3 Monate', '4'=>'4 Monate', '5'=>'5 Monate', '6'=>'6 Monate')) }}
        </span>
        <span>
            {{ Form::text('donatordate', null, array('placeholder'=>'Datum: YYYY-MM-DD', 'class'=>'datepicker')) }}
        </span>
        <span></span>
        <span>{{ Form::text('reason') }}</span>

        <span>
            <button type="submit" class="btn btn-primary btn-sm">speichern</button>
        </span>
    {{ Form::close() }}

    @foreach($donators as $donator)
        {{ Form::open(array('url'=>'donators/edit')) }}
        <span>{{ $donator->uid }}</span>
        <span>
            {{ $donator->playerid }}
        </span>
        <span>
            {{ $donator->name }}
        </span>
        <span>
            {{ date('d.m.Y H:i', strtotime($donator->created_at)) }}
        </span>
        <span>
            {{ date('d.m.Y H:i', strtotime($donator->updated_at)) }}
        </span>
        <span>
            {{ Form::select('donatorlvl', array('0'=>'kein Donator', '5'=>'Donator'), $donator->donatorlvl) }}
        </span>
        <span>
            {{ Form::number('donatoramount', $donator->donatoramount, array('placeholder'=>'Betrag')) }}
        </span>
        <span>
            {{ Form::select('donatorduration', array('1'=>'1 Monat', '2'=>'2 Monate', '3'=>'3 Monate', '4'=>'4 Monate', '5'=>'5 Monate', '6'=>'6 Monate'), $donator->donatorduration) }}
        </span>
        <span>
            {{ Form::text('donatordate', $donator->donatordate, array('placeholder'=>'Datum: YYYY-MM-DD', 'class'=>'datepicker', 'data-value'=>$donator->donatordate)) }}
        </span>
        <span>
            {{ $donator->donatorexpires }}
        </span>
        <span>{{ Form::text('reason') }}</span>

        <span>
            <input type="hidden" name="uid" value="{{ $donator->uid }}" />
            <input type="hidden" name="playerid" value="{{ $donator->playerid }}" />
            <button type="submit" class="btn btn-primary btn-sm">speichern</button>
        </span>
        {{ Form::close() }}
    @endforeach
    <div class="tfoot">
        <strong>ID</strong>
        <strong>Spieler-ID</strong>
        <strong>Name</strong>
        <strong>erster Login</strong>
        <strong>letztes Update</strong>
        <strong>Donator-Level</strong>
        <strong>Donator-Betrag</strong>
        <strong>Donator-Dauer</strong>
        <strong>Donator seit</strong>
        <strong>Donator bis</strong>
        <strong>Begründung</strong>
        <strong></strong>
    </div>
</div>

{{ $donators->links() }}
<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<h2>Fahrzeuge @if($database == 'arma3life')<span class="label label-danger">LIVE</span>@endif</h2>

<div class="row">
    <div class="col-md-10">
        {{ Form::open(array('url'=>'vehicles', 'method'=>'GET')) }}
        <div class="input-group">
            <input type="text" name="s" class="form-control" placeholder="Spieler-ID || Klassenname" value="{{ $search }}">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">suchen</button>
            </span>
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-md-1">
        <a href="?t=alive" class="btn btn-primary btn-block">ganz</a>
    </div>
    <div class="col-md-1">
        <a href="?t=destroyed" class="btn btn-primary btn-block">kaputt</a>
    </div>
</div>

@if(Session::has('message') && Session::has('type'))
    <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('message') }}
    </div>
@endif

@if(empty($search) && empty($type))
    {{ $all_vehicles->links() }}
@endif

<div class="table table-hover">
    <div class="thead">
        <strong>ID</strong>
        <strong>Spieler-ID</strong>
        <strong>Seite</strong>
        <strong>Fahrzeugtyp</strong>
        <strong>Klassenname</strong>
        <strong>ganz</strong>
        <strong>ausgeparkt</strong>
        <strong>löschen</strong>
        <strong></strong>
    </div>
    @foreach($all_vehicles as $vehicle)
        {{ Form::open(array('url'=>'vehicle/edit')) }}
            <span>{{ $vehicle->id }}</span>
            <span>{{ $vehicle->pid }}</span>
            <span>{{ strtoupper($vehicle->side) }}</span>
            <span>
                {{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}
            </span>
            <span>
                {{ $vehicle->classname }}
            </span>
            <span>{{ Form::checkbox('alive', '1', $vehicle->alive); }}</span>
            <span>{{ Form::checkbox('active', '1', $vehicle->active); }}</span>
            <span>{{ Form::checkbox('delete', '1'); }}</span>

            <span>
                <input type="hidden" name="vehicleid" value="{{ $vehicle->id }}" />
                <input type="hidden" name="playerid" value="{{ $vehicle->pid }}" />
                <button type="submit" class="btn btn-primary btn-sm">speichern</button>
            </span>
        {{ Form::close() }}
    @endforeach
    <div class="tfoot">
        <strong>ID</strong>
        <strong>Spieler-ID</strong>
        <strong>Seite</strong>
        <strong>Fahrzeugtyp</strong>
        <strong>Klassenname</strong>
        <strong>ganz</strong>
        <strong>ausgeparkt</strong>
        <strong>löschen</strong>
        <strong></strong>
    </div>
</div>

@if(empty($search) && empty($type))
    {{ $all_vehicles->links() }}
@endif
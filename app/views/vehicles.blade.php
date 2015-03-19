<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
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

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Spieler-ID</th>
            <th>Seite</th>
            <th>Fahrzeugtyp</th>
            <th>Klassenname</th>
            <th>ganz</th>
            <th>ausgeparkt</th>
            <th>löschen</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($all_vehicles as $vehicle)
        {{ Form::open(array('url'=>'vehicle/edit')) }}
        <tr>
            <td>{{ $vehicle->id }}</td>
            <td>{{ $vehicle->pid }}</td>
            <td>{{ strtoupper($vehicle->side) }}</td>
            <td>
                {{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}
            </td>
            <td>
                {{ $vehicle->classname }}
            </td>
            <td>{{ Form::checkbox('alive', '1', $vehicle->alive); }}</td>
            <td>{{ Form::checkbox('active', '1', $vehicle->active); }}</td>
            <td>{{ Form::checkbox('delete', '1'); }}</td>

            <td>
                <input type="hidden" name="vehicleid" value="{{ $vehicle->id }}" />
                <input type="hidden" name="playerid" value="{{ $vehicle->pid }}" />
                <button type="submit" class="btn btn-primary btn-sm">speichern</button>
            </td>
        </tr>
        {{ Form::close() }}
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Spieler-ID</th>
            <th>Seite</th>
            <th>Fahrzeugtyp</th>
            <th>Klassenname</th>
            <th>ganz</th>
            <th>ausgeparkt</th>
            <th>löschen</th>
            <th></th>
        </tr>
    </tfoot>
</table>
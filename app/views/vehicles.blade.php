<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<div class="container-fluid">
    <div class="row">
        {{ View::make('partials/sidebar', array('level_label'=>$level_label)) }}

        <div class="col-md-10">
            <h2>Fahrzeuge</h2>

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
                        <th>Fahrzeug</th>
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
                            {{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }} | {{ $vehicle->classname }}
                        </td>
                        <td>{{ Form::checkbox('alive', '1', $vehicle->alive); }}</td>
                        <td>{{ Form::checkbox('active', '1', $vehicle->active); }}</td>
                        <td>{{ Form::checkbox('delete', '1', $vehicle->delete); }}</td>

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
                        <th>Fahrzeug</th>
                        <th>ganz</th>
                        <th>ausgeparkt</th>
                        <th>löschen</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 1.0
 */
?>

<h2>Logs</h2>

<div class="row">
    <div class="col-md-9">
        {{ Form::open(array('url'=>'logs', 'method'=>'GET')) }}
        <div class="input-group">
            <input type="text" name="s" class="form-control" placeholder="Bearbeiter: e16 || Fahrzeug: v345 || Spieler: p246 || Gang: g14 || Datum: d2015-03-30" value="{{ $search }}">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">suchen</button>
            </span>
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-md-1">
        <a href="?t=p" class="btn btn-primary btn-block">Spieler</a>
    </div>
    <div class="col-md-1">
        <a href="?t=v" class="btn btn-primary btn-block">Fahrzeuge</a>
    </div>
    <div class="col-md-1">
        <a href="?t=g" class="btn btn-primary btn-block">Gangs</a>
    </div>
</div>

@if(empty($search) && empty($type))
    {{ $logs->links() }}
@endif

<div class="table table-hover">
    <div class="thead">
        <strong>ID</strong>
        <strong>Typ</strong>
        <strong>Bearbeiter</strong>
        <strong>Objekt</strong>
        <strong>Verändert</strong>
        <strong>Zeitpunkt</strong>
    </div>
    @foreach($logs as $log)
        <div>
            <span>{{ $log->id }}</span>
            <span>{{ $log->type }}</span>
            <span>{{ $log->editor_name }} ({{ $log->editor }})</span>
            <span>{{ $log->object_name }} ({{ $log->objectid }})@if($log->type = 'Fahrzeug' && $log->playerid != 0) von {{ Player::find($log->playerid)['name'] }} ({{ $log->playerid }})@endif</span>
            <span>
                @foreach($log->differences as $difference)
                    @if($difference[0] == 'civ_licenses')
                        <span class="label label-info label-list">CIV Lizenzen</span>
                    @elseif($difference[0] == 'cop_licenses')
                        <span class="label label-info label-list">COP Lizenzen</span>
                    @elseif($difference[0] == 'med_licenses')
                        <span class="label label-info label-list">MEDIC Lizenzen</span>
                    @elseif($difference[0] == 'adac_licenses')
                        <span class="label label-info label-list">ADAC Lizenzen</span>
                    @elseif($difference[0] == 'members')
                        <span class="label label-info label-list">Mitglieder</span>
                    @elseif($difference[0] == 'deleted')
                        <span class="label label-danger label-list">gelöscht</span>
                    @else
                        <span class="label label-info label-list">{{ $difference[0] }} {{ $difference[1] }} -> {{ $difference[2] }}</span>
                    @endif
                @endforeach
            </span>
            <span>{{ date('d.m.Y H:i', strtotime($log->created_at)) }}</span>
        </div>
    @endforeach
    <div class="tfoot">
        <strong>ID</strong>
        <strong>Typ</strong>
        <strong>Bearbeiter</strong>
        <strong>Objekt</strong>
        <strong>Verändert</strong>
        <strong>Zeitpunkt</strong>
    </div>
</div>

@if(empty($search) && empty($type))
    {{ $logs->links() }}
@endif
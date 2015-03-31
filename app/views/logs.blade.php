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

{{ $logs->links() }}

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
            <span>{{ $log->editor_name }}</span>
            <span>{{ $log->object_name }}@if($log->type = 'Fahrzeug' && $log->playerid != 0) von {{ Player::find($log->playerid)['name'] }}@endif</span>
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

{{ $logs->links() }}
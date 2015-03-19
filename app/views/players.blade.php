<?php
/**
 * ide: PhpStorm
 * Author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<div class="container-fluid">
    <div class="row">
        {{ View::make('partials/sidebar', array('level_label'=>$level_label)) }}

        <div class="col-md-10">
            <h2>Spieler @if($database == 'arma3life')<span class="label label-danger">LIVE</span>@endif</h2>

            @if(Session::has('message') && Session::has('type'))
                <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ Session::get('message') }}
                </div>
            @endif

            <div class="table table-hover">
                <div>
                    <strong>ID</strong>
                    <strong>Spieler-ID</strong>
                    <strong>Name</strong>
                    <strong>Bargeld</strong>
                    <strong>Bankguthaben</strong>
                    <strong>CIV-Lizenzen</strong>
                    <strong>COP-Level</strong>
                    <strong>COP-Lizenzen</strong>
                    <strong>MEDIC-Level</strong>
                    <strong>MEDIC-Lizenzen</strong>
                    <strong>ADAC-Level</strong>
                    <strong>ADAC-Lizenzen</strong>
                    <strong>Donator-Level</strong>
                    <strong>Admin-Level</strong>
                    <strong></strong>
                </div>
                @foreach($players as $player)
                    @if(count(Auth::user()->decodeDBArray($player->civ_licenses)) || count(Auth::user()->decodeDBArray($player->cop_licenses)) || count(Auth::user()->decodeDBArray($player->med_licenses)) || count(Auth::user()->decodeDBArray($player->adac_licenses)))
                        {{ Form::open(array('url'=>'player/edit')) }}
                            <span>{{ $player->uid }}</span>
                            <span>{{ $player->playerid }}</span>
                            <span>{{ $player->name }}</span>
                            <span>@if(Auth::user()->level >= 3){{ Form::number('cash', $player->cash) }}@else{{ number_format($player->cash, 2, ',', '.') }}@endif</span>
                            <span>@if(Auth::user()->level >= 3){{ Form::number('bankacc', $player->bankacc) }}@else{{ number_format($player->bankacc, 2, ',', '.') }}@endif</span>
                            <span id="civ_licenses_{{ $player->playerid }}_holder">
                                @if(count(Auth::user()->decodeDBArray($player->civ_licenses)))
                                    <p><button class="btn btn-info btn-sm" type="button" data-parent="#civ_licenses_{{ $player->playerid }}_holder" data-toggle="collapse" data-target="#civ_licenses_{{ $player->playerid }}">CIV Lizenzen</button></p>
                                    <div class="collapse" id="civ_licenses_{{ $player->playerid }}">
                                        @foreach(Auth::user()->decodeDBArray($player->civ_licenses) as $license)
                                            @if($licenses->$license[0] != false)
                                                @if($license[1])
                                                    <span class="label label-success label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', true); }}@endif</span>
                                                @else
                                                    <span class="label label-info label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', false); }}@endif</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>noch kein Login</p>
                                @endif
                            </span>
                            <span>@if(Auth::user()->level >= 1){{ Form::number('coplevel', $player->coplevel, array('min'=>0, 'max'=>11)) }}@else{{ $player->coplevel }}@endif</span>
                            <span id="cop_licenses_{{ $player->playerid }}_holder">
                                @if(count(Auth::user()->decodeDBArray($player->cop_licenses)))
                                    <p><button class="btn btn-info btn-sm" type="button" data-parent="#cop_licenses_{{ $player->playerid }}_holder" data-toggle="collapse" data-target="#cop_licenses_{{ $player->playerid }}">COP Lizenzen</button></p>
                                    <div class="collapse" id="cop_licenses_{{ $player->playerid }}">
                                        @foreach(Auth::user()->decodeDBArray($player->cop_licenses) as $license)
                                            @if($licenses->$license[0] != false)
                                                @if($license[1])
                                                    <span class="label label-success label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', true); }}@endif</span>
                                                @else
                                                    <span class="label label-info label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', false); }}@endif</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>noch kein Login</p>
                                @endif
                            </span>
                            <span>@if(Auth::user()->level >= 1){{ Form::number('mediclevel', $player->mediclevel, array('min'=>0, 'max'=>5)) }}@else{{ $player->mediclevel }}@endif</span>
                            <span id="med_licenses_{{ $player->playerid }}_holder">
                                @if(count(Auth::user()->decodeDBArray($player->med_licenses)))
                                    <p><button class="btn btn-info btn-sm" type="button" data-parent="#med_licenses_{{ $player->playerid }}_holder" data-toggle="collapse" data-target="#med_licenses_{{ $player->playerid }}">MEDIC Lizenzen</button></p>
                                    <div class="collapse" id="med_licenses_{{ $player->playerid }}">
                                        @foreach(Auth::user()->decodeDBArray($player->med_licenses) as $license)
                                            @if($licenses->$license[0] != false)
                                                @if($license[1])
                                                    <span class="label label-success label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', true); }}@endif</span>
                                                @else
                                                    <span class="label label-info label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', false); }}@endif</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>noch kein Login</p>
                                @endif
                            </span>
                            <span>@if(Auth::user()->level >= 1){{ Form::number('adaclevel', $player->adaclevel, array('min'=>0, 'max'=>5)) }}@else{{ $player->adaclevel }}@endif</span>
                            <span id="adac_licenses_{{ $player->playerid }}_holder">
                                @if(count(Auth::user()->decodeDBArray($player->adac_licenses)))
                                    <p><button class="btn btn-info btn-sm" type="button" data-parent="#adac_licenses_{{ $player->playerid }}_holder" data-toggle="collapse" data-target="#adac_licenses_{{ $player->playerid }}">ADAC Lizenzen</button></p>
                                    <div class="collapse" id="adac_licenses_{{ $player->playerid }}">
                                        @foreach(Auth::user()->decodeDBArray($player->adac_licenses) as $license)
                                            @if($licenses->$license[0] != false)
                                                @if($license[1])
                                                    <span class="label label-success label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', true); }}@endif</span>
                                                @else
                                                    <span class="label label-info label-list">{{ $licenses->$license[0] }}@if(Auth::user()->level >= 2) {{ Form::checkbox($license[0], '1', false); }}@endif</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>noch kein Login</p>
                                @endif
                            </span>
                            <span>@if(Auth::user()->level >= 4){{ Form::number('donatorlvl', $player->donatorlvl, array('min'=>0, 'max'=>5)) }}@else{{ $player->donatorlvl }}@endif</span>
                            <span>@if(Auth::user()->level >= 4){{ Form::number('adminlevel', $player->adminlevel, array('min'=>0, 'max'=>3)) }}@else{{ $player->adminlevel }}@endif</span>

                            <span>
                                <input type="hidden" name="uid" value="{{ $player->uid }}" />
                                <input type="hidden" name="playerid" value="{{ $player->playerid }}" />
                                <button type="submit" class="btn btn-primary btn-sm">speichern</button>
                            </span>
                        {{ Form::close() }}
                    @endif
                @endforeach
                <div>
                    <strong>ID</strong>
                    <strong>Spieler-ID</strong>
                    <strong>Name</strong>
                    <strong>Bargeld</strong>
                    <strong>Bankguthaben</strong>
                    <strong>CIV-Lizenzen</strong>
                    <strong>COP-Level</strong>
                    <strong>COP-Lizenzen</strong>
                    <strong>MEDIC-Level</strong>
                    <strong>MEDIC-Lizenzen</strong>
                    <strong>ADAC-Level</strong>
                    <strong>ADAC-Lizenzen</strong>
                    <strong>Donator-Level</strong>
                    <strong>Admin-Level</strong>
                    <strong></strong>
                </div>
            </div>
        </div>
    </div>
</div>
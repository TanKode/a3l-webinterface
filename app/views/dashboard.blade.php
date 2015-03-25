<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
*/
?>

<h2>Dashboard @if($database == 'arma3life')<span class="label label-danger">LIVE</span>@endif</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Übersicht</h3>
        <ul class="list-group">
            <li class="list-group-item"><i class="icon-user"></i> Spieler<span class="badge">{{ $counter['players'] }}</span></li>
            <li class="list-group-item"><i class="icon-supportalt"></i> Admins<span class="badge">{{ $counter['admins'] }}</span></li>
            <li class="list-group-item"><i class="icon-handcuffs"></i> Polizisten<span class="badge">{{ $counter['cops'] }}</span></li>
            <li class="list-group-item"><i class="icon-firstaid"></i> Medics<span class="badge">{{ $counter['medics'] }}</span></li>
            <li class="list-group-item"><i class="icon-construction"></i> ADAC<span class="badge">{{ $counter['adac'] }}</span></li>
            <li class="list-group-item"><i class="icon-bill"></i> Donatoren<span class="badge">{{ $counter['donators'] }}</span></li>
            <li class="list-group-item"><i class="icon-money-cash"></i> Bargeld<span class="badge">{{ number_format($counter['cash'], 2, ',', '.') }}</span></li>
            <li class="list-group-item"><i class="icon-bank"></i> Bankeinlagen<span class="badge">{{ number_format($counter['bank'], 2, ',', '.') }}</span></li>
            <li class="list-group-item"><i class="icon-automobile-car"></i> Fahrzeuge<span class="badge">{{ $counter['vehicles'] - $counter['vehicles_destroyed'] }}</span></li>
            <li class="list-group-item"><i class="icon-house"></i> Häuser<span class="badge">{{ $counter['houses'] }}</span></li>
            <li class="list-group-item"><i class="icon-groups-friends"></i> Gangs<span class="badge">{{ $counter['gangs'] }}</span></li>
        </ul>
    </div>
    <div class="col-md-8">
        <h3>
            Profil
            <small>{{ $current_player->name }}</small>
        </h3>
        <p class="well">
            <strong>Aliases:</strong> {{ $current_player->aliases }}
        </p>

        <ul class="list-group">
            <li class="list-group-item"><i class="icon-barcode"></i> Spieler-ID<span class="badge">{{ $current_player->playerid }}</span></li>
            <li class="list-group-item"><i class="icon-money-cash"></i> Bargeld<span class="badge">{{ number_format($current_player->cash, 2, ',', '.') }}</span></li>
            <li class="list-group-item"><i class="icon-bank"></i> Bankguthaben<span class="badge">{{ number_format($current_player->bankacc, 2, ',', '.') }}</span></li>
            <li class="list-group-item"><i class="icon-handcuffs"></i> Polizei-Rang<span class="badge">{{ $current_player->coplevel_name }}</span></li>
            <li class="list-group-item"><i class="icon-firstaid"></i> Medic-Rang<span class="badge">{{ $current_player->mediclevel_name }}</span></li>
            <li class="list-group-item"><i class="icon-construction"></i> ADAC-Rang<span class="badge">{{ $current_player->adaclevel_name }}</span></li>
        </ul>



        <div>
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a href="#civ_details" data-toggle="tab">Zivilist</a></li>
                @if($current_player->coplevel > 0)
                    <li><a href="#cop_details" data-toggle="tab"><i class="icon-handcuffs"></i> {{ $current_player->coplevel_name }}</a></li>
                @endif
                @if($current_player->mediclevel > 0)
                    <li><a href="#medic_details" data-toggle="tab"><i class="icon-firstaid"></i> {{ $current_player->mediclevel_name }}</a></li>
                @endif
                @if($current_player->adaclevel > 0)
                    <li><a href="#adac_details" data-toggle="tab"><i class="icon-construction"></i> {{ $current_player->adaclevel_name }}</a></li>
                @endif
            </ul>

            <div id="civ_details" class="tab-pane active">
                <div class="list-group">
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Lizenzen</h4>
                        <p class="list-group-item-text clearfix">
                            @foreach(Auth::user()->decodeDBArray($current_player->civ_licenses) as $license)
                                @if($licenses->$license[0] != false)
                                    @if($license[1])
                                        <span class="label label-success label-list">{{ $licenses->$license[0] }}</span>
                                    @else
                                        <span class="label label-info label-list">{{ $licenses->$license[0] }}</span>
                                    @endif
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Skilllevel</h4>
                        <p class="list-group-item-text clearfix">
                            @foreach(Auth::user()->decodeDBArray($current_player->civ_prof) as $prof)
                                @if(!empty($profs->$prof[0]))
                                    @if($prof[1] > 1)
                                        <span class="label label-success label-list">{{ $profs->$prof[0] }} - {{ $prof[1] }}</span>
                                    @else
                                        <span class="label label-info label-list">{{ $profs->$prof[0] }} - {{ $prof[1] }}</span>
                                    @endif
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div class="list-group-item">
                        <h4 class="list-group-item-heading">Fahrzeuge</h4>
                        <p class="list-group-item-text clearfix">
                            @foreach($current_player_vehicles as $vehicle)
                                @if(strtoupper($vehicle->side) == 'CIV')
                                    <span class="label label-info label-list">{{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}</span>
                                @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>

            @if($current_player->coplevel > 0)
                <div id="cop_details" class="tab-pane">
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Lizenzen</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach(Auth::user()->decodeDBArray($current_player->cop_licenses) as $license)
                                    @if($licenses->$license[0] != false)
                                        @if($license[1])
                                            <span class="label label-success label-list">{{ $licenses->$license[0] }}</span>
                                        @else
                                            <span class="label label-info label-list">{{ $licenses->$license[0] }}</span>
                                        @endif
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Fahrzeuge</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach($current_player_vehicles as $vehicle)
                                    @if(strtoupper($vehicle->side) == 'COP')
                                        <span class="label label-info label-list">{{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}</span>
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($current_player->mediclevel > 0)
                <div id="medic_details" class="tab-pane">
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Lizenzen</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach(Auth::user()->decodeDBArray($current_player->med_licenses) as $license)
                                    @if($licenses->$license[0] != false)
                                        @if($license[1])
                                            <span class="label label-success label-list">{{ $licenses->$license[0] }}</span>
                                        @else
                                            <span class="label label-info label-list">{{ $licenses->$license[0] }}</span>
                                        @endif
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Fahrzeuge</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach($current_player_vehicles as $vehicle)
                                    @if(strtoupper($vehicle->side) == 'MED')
                                        <span class="label label-info label-list">{{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}</span>
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if($current_player->adaclevel > 0)
                <div id="adac_details" class="tab-pane">
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Lizenzen</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach(Auth::user()->decodeDBArray($current_player->adac_licenses) as $license)
                                    @if($licenses->$license[0] != false)
                                        @if($license[1])
                                            <span class="label label-success label-list">{{ $licenses->$license[0] }}</span>
                                        @else
                                            <span class="label label-info label-list">{{ $licenses->$license[0] }}</span>
                                        @endif
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="list-group-item">
                            <h4 class="list-group-item-heading">Fahrzeuge</h4>
                            <p class="list-group-item-text clearfix">
                                @foreach($current_player_vehicles as $vehicle)
                                    @if(strtoupper($vehicle->side) == 'ADAC')
                                        <span class="label label-info label-list">{{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }}</span>
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
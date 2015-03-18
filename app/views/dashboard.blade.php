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
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <h3>Übersicht</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Web-Tool Benutzer<span class="badge">{{ $counter['users'] }}</span></li>
                        <li class="list-group-item">Spieler<span class="badge">{{ $counter['players'] }}</span></li>
                        <li class="list-group-item">Fahrzeuge<span class="badge">{{ $counter['vehicles'] }}</span></li>
                        <li class="list-group-item">Häuser<span class="badge">{{ $counter['houses'] }}</span></li>
                        <li class="list-group-item">Gangs<span class="badge">{{ $counter['gangs'] }}</span></li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <h3>
                        Profil
                        <small>{{ $current_player->name }}</small>
                    </h3>

                    <ul class="list-group">
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
                                <li><a href="#cop_details" data-toggle="tab">{{ $current_player->coplevel_name }}</a></li>
                            @endif
                            @if($current_player->mediclevel > 0)
                                <li><a href="#medic_details" data-toggle="tab">{{ $current_player->mediclevel_name }}</a></li>
                            @endif
                            @if($current_player->adaclevel > 0)
                                <li><a href="#adac_details" data-toggle="tab">{{ $current_player->adaclevel_name }}</a></li>
                            @endif
                        </ul>

                        <div id="civ_details" class="tab-pane active">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <h4 class="list-group-item-heading">Lizenzen</h4>
                                    <p class="list-group-item-text clearfix">
                                        @foreach(Auth::user()->parseDBArray($current_player->civ_licenses) as $licence)
                                            @if($licenses->$licence[0] != false)
                                                @if($licence[1])
                                                    <span class="label label-success label-list">{{ $licenses->$licence[0] }}</span>
                                                @else
                                                    <span class="label label-info label-list">{{ $licenses->$licence[0] }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div class="list-group-item">
                                    <h4 class="list-group-item-heading">Skilllevel</h4>
                                    <p class="list-group-item-text clearfix">
                                        @foreach(Auth::user()->parseDBArray($current_player->civ_prof) as $prof)
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
                                            <span class="label label-info label-list">{{ !empty($vehicles[$vehicle->classname]) ? $vehicles[$vehicle->classname] : $vehicle->classname }} | {{ strtoupper($vehicle->side) }}</span>
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
                                            @foreach(Auth::user()->parseDBArray($current_player->cop_licenses) as $licence)
                                                @if($licenses->$licence[0] != false)
                                                    @if($licence[1])
                                                        <span class="label label-success label-list">{{ $licenses->$licence[0] }}</span>
                                                    @else
                                                        <span class="label label-info label-list">{{ $licenses->$licence[0] }}</span>
                                                    @endif
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
                                            @foreach(Auth::user()->parseDBArray($current_player->med_licenses) as $licence)
                                                @if($licenses->$licence[0] != false)
                                                    @if($licence[1])
                                                        <span class="label label-success label-list">{{ $licenses->$licence[0] }}</span>
                                                    @else
                                                        <span class="label label-info label-list">{{ $licenses->$licence[0] }}</span>
                                                    @endif
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
                                            @foreach(Auth::user()->parseDBArray($current_player->adac_licenses) as $licence)
                                                @if($licenses->$licence[0] != false)
                                                    @if($licence[1])
                                                        <span class="label label-success label-list">{{ $licenses->$licence[0] }}</span>
                                                    @else
                                                        <span class="label label-info label-list">{{ $licenses->$licence[0] }}</span>
                                                    @endif
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
        </div>
    </div>
</div>
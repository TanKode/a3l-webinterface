<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Profil</h3></div>
        <ul class="list-group">
            <li class="list-group-item">
                Spieler-ID
                <span class="badge">{{ Auth::User()->player->playerid }}</span>
            </li>
            <li class="list-group-item">
                Name
                <a href="{{ url('player/profile/'.Auth::User()->player->uid) }}" class="badge">{{ Auth::User()->player->name }}</a>
            </li>
            <li class="list-group-item">
                Geld
                <span class="badge">{{ Auth::User()->player->total_money }}</span>
            </li>
            @if(count(Auth::User()->player->gang()) == 1)
                <li class="list-group-item">
                    Gang
                    <div class="list-group-item-text">
                        <ul class="list-inline">
                            <li><span class="label label-default">{{ Auth::User()->player->gang()->name }}</span></li>
                            <li><span class="label label-default">@if(Auth::User()->player->isGangOwner()) Gründer @else Mitglied @endif</span></li>
                        </ul>
                    </div>
                </li>
            @endif
            @if(Auth::User()->player->civVehicles->count() > 0)
                <li class="list-group-item">
                    Civ Fahrzeuge
                    <span class="badge">{{ Auth::User()->player->civVehicles->count() }}</span>
                    <div class="list-group-item-text">
                        <ul class="list-inline">
                            @foreach(Auth::User()->player->civVehicles as $vehicle)
                                <li><span class="label label-default">{{ $vehicle->display_name }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
            @if(Auth::User()->player->copVehicles->count() > 0)
                <li class="list-group-item">
                    Cop Fahrzeuge
                    <span class="badge">{{ Auth::User()->player->copVehicles->count() }}</span>
                    <div class="list-group-item-text">
                        <ul class="list-inline">
                            @foreach(Auth::User()->player->copVehicles as $vehicle)
                                <li><span class="label label-default">{{ $vehicle->display_name }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
            @if(Auth::User()->player->medVehicles->count() > 0)
                <li class="list-group-item">
                    Med Fahrzeuge
                    <span class="badge">{{ Auth::User()->player->medVehicles->count() }}</span>
                    <div class="list-group-item-text">
                        <ul class="list-inline">
                            @foreach(Auth::User()->player->medVehicles as $vehicle)
                                <li><span class="label label-default">{{ $vehicle->display_name }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
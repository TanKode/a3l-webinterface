<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<header class="row">
    <div class="col-md-2">
        <div class="media">
            <div class="media-left"><img class="media-object" src="{{ Auth::user()->getAvatar(Auth::user()->email, 48) }}" alt="Avatar" /></div>
            <div class="media-body">
                <h4 class="media-heading">{{ Auth::user()->username }}</h4>
                {{ $level_label[Auth::user()->level] }}
            </div>
        </div>
    </div>

    <nav class="col-md-10">
        <ul class="nav nav-pills">
            <li @if(Request::is('/'))class="active"@endif><a href="{{ url('/') }}"><i class="icon-clipboard-paste"></i> Dashboard</a></li>
            <li @if(Request::is('statistics'))class="active"@endif><a href="{{ url('statistics') }}"><i class="icon-awstats"></i> Statistiken</a></li>
            @if(Auth::user()->level >= 1)
                <li @if(Request::is('players'))class="active"@endif><a href="{{ url('players') }}"><i class="icon-user"></i> Spieler <span class="badge">{{ $counter['players'] }}</span></a></li>
            @endif
            @if(Auth::user()->level >= 2)
                <li @if(Request::is('vehicles'))class="active"@endif><a href="{{ url('vehicles') }}"><i class="icon-automobile-car"></i> Fahrzeuge <span class="badge">{{ $counter['vehicles'] - $counter['vehicles_destroyed'] }}</span></a></li>
            @endif
            @if(Auth::user()->level >= 2)
                <li @if(Request::is('gangs'))class="active"@endif><a href="{{ url('gangs') }}"><i class="icon-groups-friends"></i> Gangs <span class="badge">{{ $counter['gangs'] }}</span></a></li>
            @endif
            @if(Auth::user()->level >= 4)
                <li @if(Request::is('donators'))class="active"@endif><a href="{{ url('donators') }}"><i class="icon-bill"></i> Donatoren <span class="badge">{{ $counter['donators'] }}</span></a></li>
                <li @if(Request::is('logs'))class="active"@endif><a href="{{ url('logs') }}"><i class="icon-rawaccesslogs"></i> Logs <span class="badge">{{ $counter['logs'] }}</span></a></li>
                <li @if(Request::is('webuser'))class="active"@endif><a href="{{ url('webuser') }}"><i class="icon-supportalt"></i> Webnutzer <span class="badge">{{ $counter['users'] }}</span></a></li>
            @endif
            @if(Auth::user()->level = 5)
                <li><a href="{{ url('clearcache') }}"><i class="icon-databasedelete"></i> Cache löschen</a></li>
            @endif
            <li><a href="{{ url('user/logout') }}"><i class="icon-key"></i> abmelden</a></li>
        </ul>
    </nav>
</header>
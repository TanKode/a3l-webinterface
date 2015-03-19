<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<div class="row">
    <div class="col-md-2">
        <div class="media">
            <div class="media-left"><img class="media-object" src="{{ Auth::user()->getAvatar(Auth::user()->email, 48) }}" alt="Avatar" /></div>
            <div class="media-body">
                <h4 class="media-heading">{{ Auth::user()->username }}</h4>
                {{ $level_label[Auth::user()->level] }}
            </div>
        </div>
    </div>

    <div class="col-md-10">
        <ul class="nav nav-pills">
            <li><a href="{{ url('/') }}"><i class="icon-clipboard-paste"></i> Dashboard</a></li>
            @if(Auth::user()->level >= 1)
                <li><a href="{{ url('players') }}"><i class="icon-user"></i> Spieler</a></li>
            @endif
            @if(Auth::user()->level >= 2)
                <li><a href="{{ url('vehicles') }}"><i class="icon-automobile-car"></i> Fahrzeuge</a></li>
            @endif
            @if(Auth::user()->level >= 4)
                <li><a href="{{ url('webuser') }}"><i class="icon-supportalt"></i> Web-User</a></li>
            @endif
            <li><a href="{{ url('user/logout') }}"><i class="icon-key"></i> abmelden</a></li>
        </ul>
    </div>
</div>
<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<div class="col-md-2">
    <h2>Navigation</h2>
    <div class="media">
        <div class="media-left"><img class="media-object" src="{{ Auth::user()->getAvatar(Auth::user()->email, 48) }}" alt="Avatar" /></div>
        <div class="media-body">
            <h4 class="media-heading">{{ Auth::user()->username }}</h4>
            {{ $level_label[Auth::user()->level] }}
        </div>
    </div>

    <ul class="nav nav-pills nav-stacked">
        <li>{{ HTML::link('/', 'Dashboard') }}</li>
        @if(Auth::user()->level >= 1)
            <li>{{ HTML::link('vehicles', 'Fahrzeuge') }}</li>
        @endif
        @if(Auth::user()->level >= 4)
            <li>{{ HTML::link('webuser', 'Web-User') }}</li>
        @endif
        <li>{{ HTML::link('user/logout', 'abmelden') }}</li>
    </ul>
</div>
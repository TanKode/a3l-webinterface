<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * subpackage: views
 * since 0.1
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <h2>Navigation</h2>
            <div class="media">
                <div class="media-left"><img class="media-object" src="{{ Auth::user()->getAvatar(Auth::user()->email, 48) }}" alt="Avatar" /></div>
                <div class="media-body">
                    <h4 class="media-heading">{{ Auth::user()->username }}</h4>
                    {{ $level_label }} {{ HTML::link('user/logout', 'abmelden') }}
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <h2>Dashboard</h2>
        </div>
    </div>
</div>
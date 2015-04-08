<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<h2>Web-User</h2>

@if(Session::has('message') && Session::has('type'))
    <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('message') }}
    </div>
@endif

<div class="row">
    <div class="col-md-10">
        {{ $webusers->links() }}
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#userRightModal">Nutzer-Rechte-Übersicht</button>
    </div>
</div>

<div class="table table-hover">
    <div class="thead">
        <strong></strong>
        <strong>ID</strong>
        <strong>Nutzername</strong>
        <strong>Spieler-ID</strong>
        <strong>E-Mail</strong>
        <strong>Rechtelevel</strong>
        <strong></strong>
    </div>
    @foreach($webusers as $webuser)
        {{ Form::open(array('url'=>'user/edit')) }}
            <span><img src="{{ Auth::user()->getAvatar($webuser->email, 32) }}" alt="Avatar" /></span>
            <span>{{ $webuser->id }}</span>
            <span>{{ $webuser->username }}</span>
            <span>{{ $webuser->playerid }}</span>
            <span><a href="mailto:{{ $webuser->email }}">{{ $webuser->email }}</a></span>
            <span>{{ Form::number('level', $webuser->level, array('min'=>0, 'max'=>5)) }} {{ $level_label[$webuser->level] }}</span>
            <span>
                {{ Form::hidden('userid', $webuser->id) }}
                <button type="submit" class="btn btn-primary btn-sm">speichern</button>
            </span>
        {{ Form::close() }}
    @endforeach
    <div class="tfoot">
        <strong></strong>
        <strong>ID</strong>
        <strong>Nutzername</strong>
        <strong>Spieler-ID</strong>
        <strong>E-Mail</strong>
        <strong>Rechtelevel</strong>
        <strong></strong>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        {{ $webusers->links() }}
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#userRightModal">Nutzer-Rechte-Übersicht</button>
    </div>
</div>



<div class="modal fade" id="userRightModal" tabindex="-1" role="dialog" aria-labelledby="userRightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userRightModalLabel">Nutzer-Rechte-Übersicht</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Super-Admin</th>
                        <th>Admin</th>
                        <th>Support III</th>
                        <th>Support II</th>
                        <th>Support I</th>
                        <th>Mitglied</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-right"><strong>Seiten-Cache löschen</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Rechte-Level verändern</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Spieler Donator</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Spieler Admin</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Spieler Geld</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Gang Konto</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Gang deaktivieren</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Gang Eigentümer</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Spieler Lizenzen</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Fahrzeuge</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Gang Mitglieder</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Spieler Level</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Logs ansehen</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/error.png" alt="nein" /></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Dashboard ansehen</strong></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                        <td class="text-center"><img src="{{ asset('img') }}/check.png" alt="ja" /></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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

{{ $webusers->links() }}

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

{{ $webusers->links() }}
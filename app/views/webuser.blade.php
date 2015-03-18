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

            @if(Session::has('message') && Session::has('type'))
                <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ Session::get('message') }}
                </div>
            @endif

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nutzername</th>
                        <th>Spieler-ID</th>
                        <th>E-Mail</th>
                        <th>Rechtelevel</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($webusers as $webuser)
                    {{ Form::open(array('url'=>'user/edit')) }}
                    <tr>
                        <td>{{ $webuser->id }}</td>
                        <td>{{ $webuser->username }}</td>
                        <td>{{ $webuser->playerid }}</td>
                        <td><a href="mailto:{{ $webuser->email }}">{{ $webuser->email }}</a></td>
                        <td><input type="number" name="level" value="{{ $webuser->level }}" min="0" max="5" /> {{ $level_label[$webuser->level] }}</td>
                        <td>
                            <input type="hidden" name="userid" value="{{ $webuser->id }}" />
                            <button type="submit" class="btn btn-primary btn-sm">speichern</button>
                        </td>
                    </tr>
                    {{ Form::close() }}
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nutzername</th>
                        <th>Spieler-ID</th>
                        <th>E-Mail</th>
                        <th>Rechtelevel</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
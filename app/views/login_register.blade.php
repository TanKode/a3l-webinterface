<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.1
 */
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @if(Session::has('message') && Session::has('type'))
                <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ Session::get('message') }}
                </div>
            @endif

            <div class="panel panel-default">
                <ul class="nav nav-pills nav-justified">
                    <li class="{{ $login }}"><a href="#login_form" data-toggle="pill">Anmelden</a></li>
                    <li class="{{ $register }}"><a href="#register_form" data-toggle="pill">Registrieren</a></li>
                </ul>
                {{ Form::open(array('url'=>'user/login', 'id'=>'login_form', 'class'=>'tab-pane '.$login)) }}
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('email', 'E-Mail'); }}
                            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'E-Mail')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Passwort'); }}
                            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Passwort')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::submit('anmelden', array('class'=>'btn btn-large btn-primary btn-block'))}}
                    </div>
                {{ Form::close() }}

                {{ Form::open(array('url'=>'user/create', 'id'=>'register_form', 'class'=>'tab-pane '.$register)) }}
                    <div class="panel-body">
                        @if($errors->has('playerid'))
                            <div class="form-group has-error">
                        @else
                            <div class="form-group">
                        @endif
                            {{ Form::label('playerid', 'Spieler-ID', array('class'=>'control-label')); }}
                            {{ Form::text('playerid', null, array('class'=>'form-control', 'placeholder'=>'Spieler-ID')) }}
                            @if($errors->has('playerid'))
                            <ul class="list-unstyled">
                                @foreach ($errors->get('playerid') as $error)
                                    <li><small>{{ $error }}</small></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        @if($errors->has('username'))
                            <div class="form-group has-error">
                        @else
                            <div class="form-group">
                        @endif
                            {{ Form::label('username', 'Nutzername', array('class'=>'control-label')); }}
                            {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Nutzername')) }}
                            @if($errors->has('username'))
                                <ul class="list-unstyled">
                                    @foreach ($errors->get('username') as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if($errors->has('email'))
                            <div class="form-group has-error">
                        @else
                            <div class="form-group">
                        @endif
                            {{ Form::label('email', 'E-Mail', array('class'=>'control-label')); }}
                            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'E-Mail')) }}
                            @if($errors->has('email'))
                                <ul class="list-unstyled">
                                    @foreach ($errors->get('email') as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if($errors->has('password'))
                            <div class="form-group has-error">
                        @else
                            <div class="form-group">
                        @endif
                            {{ Form::label('password', 'Passwort', array('class'=>'control-label')); }}
                            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Passwort')) }}
                            @if($errors->has('password'))
                                <ul class="list-unstyled">
                                    @foreach ($errors->get('password') as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if($errors->has('password_confirmation'))
                            <div class="form-group has-error">
                        @else
                            <div class="form-group">
                        @endif
                            {{ Form::label('password_confirmation', 'Passwort wiederholen', array('class'=>'control-label')); }}
                            {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Passwort')) }}
                            @if($errors->has('password_confirmation'))
                                <ul class="list-unstyled">
                                    @foreach ($errors->get('password_confirmation') as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::submit('registrieren', array('class'=>'btn btn-large btn-primary btn-block'))}}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@extends('app')

@section('title', $user->username . ' bearbeiten')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Basis-Daten</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($user, ['url' => 'app/user/update/'.$user->id, 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::text('username', null, ['label' => 'Benutzername', 'disabled' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::email('email', null, ['label' => 'E-Mail']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::selectpicker('role_id', $selectable_roles, $user->role->id, ['label' => 'Rolle']) !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
                {!! Form::password('password', ['label' => 'Passwort']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::password('password_confirmation', ['label' => 'Passwort Wiederholung']) !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
                {!! Form::text('facebook', null, ['label' => 'Facebook', 'disabled' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::text('github', null, ['label' => 'Github', 'disabled' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::text('slack', null, ['label' => 'Slack', 'disabled' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::text('steam', null, ['label' => 'Steam', 'disabled' => true]) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
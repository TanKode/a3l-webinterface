@extends('app')

@section('title', $user->username . '\'s Profil')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="panel">
                <div class="panel-heading padding-30">
                    <img src="{{ $user->avatar(256) }}" alt="{{ $user->username }}" class="img-circle img-responsive center-block" />
                    <h2 class="panel-title text-center padding-bottom-0">{{ $user->username }}'s Profil</h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                            @if(!is_null($user->facebook))
                                <a href="{{ url('app/profile/disconnect/'.$user->id.'/facebook') }}" class="btn btn-labeled btn-block btn-dark">
                                    <span class="btn-label"><i class="icon fa-trash-o"></i></span>
                                    Facebook
                                </a>
                            @else
                                <a href="{{ url('auth/facebook') }}" class="btn btn-labeled btn-block social-facebook">
                                    <span class="btn-label"><i class="icon fa-facebook"></i></span>
                                    Facebook
                                </a>
                            @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                            @if(!is_null($user->github))
                                <a href="{{ url('app/profile/disconnect/'.$user->id.'/github') }}" class="btn btn-labeled btn-block btn-dark">
                                    <span class="btn-label"><i class="icon fa-trash-o"></i></span>
                                    Github
                                </a>
                            @else
                                <a href="{{ url('auth/github') }}" class="btn btn-labeled btn-block social-github">
                                    <span class="btn-label"><i class="icon fa-github"></i></span>
                                    Github
                                </a>
                            @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                @if(!is_null($user->slack))
                                    <a href="{{ url('app/profile/disconnect/'.$user->id.'/slack') }}" class="btn btn-labeled btn-block btn-dark">
                                        <span class="btn-label"><i class="icon fa-trash-o"></i></span>
                                        Slack
                                    </a>
                                @else
                                    <a href="{{ url('auth/steam') }}" class="btn btn-labeled btn-block social-slack">
                                        <span class="btn-label"><i class="icon fa-slack"></i></span>
                                        Slack
                                    </a>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                            @if(!is_null($user->steam))
                                <a href="{{ url('app/profile/disconnect/'.$user->id.'/steam') }}" class="btn btn-labeled btn-block btn-dark">
                                    <span class="btn-label"><i class="icon fa-trash-o"></i></span>
                                    Steam
                                </a>
                            @else
                                <a href="{{ url('auth/steam') }}" class="btn btn-labeled btn-block social-steam">
                                    <span class="btn-label"><i class="icon fa-github"></i></span>
                                    Steam
                                </a>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Basis-Daten</h3>
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['url' => 'app/profile/update/'.\Auth::User()->id, 'class' => 'row']) !!}
                    <div class="col-md-3">
                        {!! Form::text('username', null, ['label' => 'Benutzername', 'disabled' => true]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::email('email', null, ['label' => 'E-Mail']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::password('password', ['label' => 'Passwort']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::password('password_confirmation', ['label' => 'Passwort Wiederholung']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
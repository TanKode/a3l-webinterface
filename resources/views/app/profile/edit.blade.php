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
                                    <a href="{{ url('auth/slack') }}" class="btn btn-labeled btn-block social-slack">
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

            @if(!is_null($user->a3lPlayer()))
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Altis Life - {{ $user->a3lPlayer()->name }}</h3>
                    <div class="panel-actions">
                        <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Spieler-ID</strong>
                            <p>{{ $user->a3lPlayer()->playerid }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Geld</strong>
                            <p>{{ format_money($user->a3lPlayer()->cash + $user->a3lPlayer()->bankacc) }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Karma</strong>
                            <p>{{ $user->a3lPlayer()->Karma }}</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <h4>Zivilist</h4>
                            <strong>Lizenzen</strong>
                            <ul class="list-inline">
                                @foreach($user->a3lPlayer()->civ_licenses as $key => $value)
                                    <li>
                                        <span class="label label-dark">{{ trans('licenses.'.$key) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <strong>Fahrzeuge</strong>
                            <ul class="list-inline">
                                @foreach($user->a3lPlayer()->civVehicles() as $vehicle)
                                    <li><span class="label label-dark">{{ trans('vehicles.'.$vehicle->classname) }}</span></li>
                                @endforeach
                            </ul>
                            @if($user->a3lPlayer()->coplevel > 0)
                                <h4>Polizist</h4>
                                <strong>Lizenzen</strong>
                                <ul class="list-inline">
                                    @foreach($user->a3lPlayer()->cop_licenses as $key => $value)
                                        <li>
                                            <span class="label label-dark">{{ trans('licenses.'.$key) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <strong>Fahrzeuge</strong>
                                <ul class="list-inline">
                                    @foreach($user->a3lPlayer()->copVehicles() as $vehicle)
                                        <li><span class="label label-dark">{{ trans('vehicles.'.$vehicle->classname) }}</span></li>
                                    @endforeach
                                </ul>
                            @endif
                            @if($user->a3lPlayer()->mediclevel > 0)
                                <h4>Medic</h4>
                                <strong>Lizenzen</strong>
                                <ul class="list-inline">
                                    @foreach($user->a3lPlayer()->med_licenses as $key => $value)
                                        <li>
                                            <span class="label @if($value) label-success @else label-dark @endif">{{ trans('licenses.'.$key) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <strong>Fahrzeuge</strong>
                                <ul class="list-inline">
                                    @foreach($user->a3lPlayer()->medVehicles() as $vehicle)
                                        <li><span class="label label-dark">{{ trans('vehicles.'.$vehicle->classname) }}</span></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif


            @if(!is_null($user->a3eAccount()))
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Exile - {{ $user->a3eAccount()->name }}</h3>
                    <div class="panel-actions">
                        <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Spieler-ID</strong>
                            <p>{{ $user->a3eAccount()->uid }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Pop Tabs</strong>
                            <p>{{ format_int($user->a3eAccount()->money) }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Respekt</strong>
                            <p>{{ format_int($user->a3eAccount()->score) }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Gebiete</strong>
                            <p>
                                {{ $user->a3eAccount()->territories()->count() }}
                                |
                                LvL {{ $user->a3eAccount()->territories()->sum('level') }}
                                |
                                Radius  {{ $user->a3eAccount()->territories()->sum('radius') }}
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <strong>Kills</strong>
                            <p>{{ $user->a3eAccount()->kills }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Deaths</strong>
                            <p>{{ $user->a3eAccount()->deaths }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Kills / Deaths</strong>
                            <p>{{ format_float($user->a3eAccount()->kills / ($user->a3eAccount()->deaths == 0 ? 1 : $user->a3eAccount()->deaths)) }}</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <strong>Fahrzeuge</strong>
                            <ul class="list-inline">
                                @foreach($user->a3eAccount()->vehicles as $vehicle)
                                    <li><span class="label label-dark">{{ trans('vehicles.'.$vehicle->class) }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
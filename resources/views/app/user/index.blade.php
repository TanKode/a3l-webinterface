@extends('app')

@section('title', 'Benutzer Übersicht')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body" id="listjs" data-plugin="list" data-options='{"valueNames":["username","email"]}'>
            <div class="row">
                <div class="form-group col-md-10">
                    {!! Form::search('userListSearch', null, ['class' => 'search']) !!}
                </div>
                <div class="form-group col-md-2">
                    {!! Form::selectpicker('userListSort', [
                        'username' => 'Benutzername',
                        'email' => 'E-Mail',
                    ], null, ['class' => 'sort']) !!}
                </div>
            </div>

            <ul class="list-group list">
                @foreach($users as $user)
                    <li class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <div class="avatar">
                                    <img src="{{ $user->avatar() }}"/>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <strong class="username">{{ $user->username }}</strong>
                                </h4>
                                <ul class="list-inline">
                                    <li>
                                        <i class="icon fa-envelope"></i>
                                        <span class="email">{{ $user->email }}</span>
                                    </li>
                                </ul>
                                <a href="mailto:{{ $user->email }}" class="text-success icon fa-send"></a>
                                @if(\Auth::User()->canAssignRole($user->role))
                                    <a href="{{ url('app/user/edit/'.$user->id) }}" class="text-warning icon fa-pencil"></a>
                                @endif
                            </div>
                            <div class="media-right">
                                @if($user->isSuperAdmin())
                                    <span class="label label-danger label-outline">super-admin</span>
                                @else
                                <span class="label label-default label-outline">
                                    {{ $user->role->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
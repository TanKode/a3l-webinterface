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
                        </div>
                        <div class="col-md-6">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
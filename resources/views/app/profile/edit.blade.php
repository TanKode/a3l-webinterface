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
                <div class="panel-body text-center">
                    <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-labeled social-facebook @if(!is_null($user->facebook)) disabled @endif">
                        <span class="btn-label"><i class="icon bd-facebook"></i></span>
                        Facebook
                    </a>
                    <a href="{{ url('auth/github') }}" class="btn btn-block btn-labeled social-github @if(!is_null($user->github)) disabled @endif">
                        <span class="btn-label"><i class="icon bd-github"></i></span>
                        Github
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
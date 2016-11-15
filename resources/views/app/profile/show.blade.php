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
            </div>
        </div>
        <div class="col-md-9">
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
                                <strong>Karma</strong>
                                <p>{{ $user->a3lPlayer()->Karma }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Polizist</strong>
                                <p>
                                    @if($user->a3lPlayer()->coplevel > 0) ja @else nein @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <strong>THW</strong>
                                <p>
                                    @if($user->a3lPlayer()->mediclevel > 0) ja @else nein @endif
                                </p>
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
                                <strong>Respekt</strong>
                                <p>{{ format_int($user->a3eAccount()->score) }}</p>
                            </div>
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
                        </div>
                    </div>
                </div>
            @endif

            @if($user->postedThreads()->count() > 0)
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Forenaktivitäten</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            @foreach($user->postedThreads() as $thread)
                                <a class="list-group-item padding-15" href="{{ $thread->route }}">
                                    <h5 class="margin-0">
                                        @if($thread->locked)
                                            <i class="icon fa-lock text-danger"></i>
                                        @endif
                                        @if($thread->pinned)
                                            <i class="icon fa-thumb-tack text-info"></i>
                                            <strong>
                                                @endif
                                                {{ $thread->title }}
                                                @if($thread->pinned)
                                            </strong>
                                        @endif
                                        <ul class="pull-right list-inline">
                                            <li><span class="label label-dark"><i class="icon fa-comment-o"></i> {{ $thread->replyCount }}</span></li>
                                            <li><span class="label label-default"><i class="icon fa-eye"></i> {{ $thread->viewCount }}</span></li>
                                            <li><span class="label label-default">{{ $thread->authorName }} {{ $thread->lastPost->created_at->diffForHumans() }}</span></li>
                                        </ul>
                                    </h5>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
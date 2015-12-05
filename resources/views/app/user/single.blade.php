@extends('app')

@section('content')
    {!! Form::model($user, [
        'url' => $readonly ? 'dont/do/this' : 'app/user/edit/'.$user->getKey(),
    ]) !!}
    <div class="user-profile margin-top-50">
        <div class="user-display">
            <div class="bottom">
                <div class="user-avatar"><span class="status"></span><img src="{{ $user->avatar(150) }}"></div>
                <div class="user-info">
                    <h4>
                        {{ $user->name }}
                        @if($user->hasPlayer())
                            <small>
                                aka {{ $user->player->name }}
                            </small>
                        @endif
                    </h4>
                    <ul class="list-inline">
                        @foreach($user->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="panel @if($readonly) panel-success @else panel-warning @endif">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $user->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    {!! Form::text('name', null, [
                        'label' => trans('messages.username'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('name'),
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::text('email', null, [
                        'label' => trans('messages.email'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('email'),
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::text('player_id', null, [
                        'label' => trans('messages.player_id'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('player_id'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                @if(!$readonly)
                    <div class="col-md-4">
                        {!! Form::password('password', [
                            'label' => trans('messages.password'),
                            'errors' => $errors->get('password'),
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::password('password_confirmation', [
                            'label' => trans('messages.confirm'),
                            'errors' => $errors->get('password_confirmation'),
                        ]) !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        {!! Form::submit(trans('messages.save'), [
                            'class' => 'btn-warning pull-right',
                        ]) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('partials.revisions', ['model' => $user])
@endsection
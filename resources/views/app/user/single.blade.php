@extends('app')

@section('title', $user->name .' - '.trans('menu.users'))

@section('content')
    {!! Form::model($user, [
        'url' => $readonly ? 'dont/do/this' : 'app/user/edit/'.$user->getKey(),
    ]) !!}
    <div class="user-profile margin-top-50">
        <div class="user-display">
            <div class="bottom">
                <div class="user-avatar"><img src="{{ $user->avatar(150) }}"></div>
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
                @if(\Auth::id() != $user->getKey())
                <div class="clearfix"></div>
                <div class="col-md-12">
                    {!! Form::multiselect('role[]', $roles, null, [
                        'label' => trans('messages.roles'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('role'),
                    ]) !!}
                </div>
                @endif
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
                    @if(\Auth::id() != $user->getKey())
                    <div class="col-md-4">
                        {!! Form::text('confirmation_token', null, [
                            'label' => trans('messages.confirmation_token'),
                            'readonly' => true,
                            'icon' => $user->confirmed ? 'wh-ok' : 'wh-remove',
                            'state' => $user->confirmed ? 'success' : 'error',
                        ]) !!}
                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            @if(!$user->confirmed)
                                <a href="{{ url('app/user/send-verify-mail/'.$user->getKey()) }}" class="btn btn-success">{{ trans('messages.send_verify_mail') }}</a>
                            @endif
                            {!! Form::submit(trans('messages.save'), [
                                'class' => 'btn-warning',
                            ]) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @if(\Auth::id() != $user->getKey())
        @include('partials.revisions', ['model' => $user])
    @endif

    @if(\Auth::id() == $user->getKey() && $user->hasPlayer())
        <div class="panel panel-alt4">
            <header class="panel-heading">
                <h4 class="panel-title">{{ $user->player->name }}</h4>
            </header>
            <section class="panel-body">
                <div class="col-md-12">
                    <label>{{ trans('messages.civlicenses') }}</label>
                    <ul class="list-inline">
                        @foreach($user->player->civ_licenses as $license)
                            <li>
                                <p>
                                    <span class="label @if($license[1]) label-success @else label-dark @endif">
                                        {{ trans('licenses.'.$license[0]) }}
                                    </span>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-12">
                    <label>{{ trans('messages.civ_vehicles') }}</label>
                    <ul class="list-inline">
                        @foreach($user->player->vehicles()->civ()->alive()->get() as $vehicle)
                            <li>
                                <p>
                                    <span class="label @if($vehicle->active) label-warning @else label-success @endif">
                                        {{ $vehicle->display_name }}
                                    </span>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if($user->player->coplevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.coplicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->cop_licenses as $license)
                                <li>
                                    <p>
                                        <span class="label @if($license[1]) label-success @else label-dark @endif">
                                            {{ trans('licenses.'.$license[0]) }}
                                        </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('messages.cop_vehicles') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->vehicles()->cop()->alive()->get() as $vehicle)
                                <li>
                                    <p>
                                    <span class="label @if($vehicle->active) label-warning @else label-success @endif">
                                        {{ $vehicle->display_name }}
                                    </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($user->player->mediclevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.mediclicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->med_licenses as $license)
                                <li>
                                    <p>
                                        <span class="label @if($license[1]) label-success @else label-dark @endif">
                                            {{ trans('licenses.'.$license[0]) }}
                                        </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('messages.medic_vehicles') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->vehicles()->medic()->alive()->get() as $vehicle)
                                <li>
                                    <p>
                                    <span class="label @if($vehicle->active) label-warning @else label-success @endif">
                                        {{ $vehicle->display_name }}
                                    </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($user->player->ataclevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.ataclicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->atac_licenses as $license)
                                <li>
                                    <p>
                                        <span class="label @if($license[1]) label-success @else label-dark @endif">
                                            {{ trans('licenses.'.$license[0]) }}
                                        </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('messages.atac_vehicles') }}</label>
                        <ul class="list-inline">
                            @foreach($user->player->vehicles()->atac()->alive()->get() as $vehicle)
                                <li>
                                    <p>
                                    <span class="label @if($vehicle->active) label-warning @else label-success @endif">
                                        {{ $vehicle->display_name }}
                                    </span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>
        </div>
    @endif
@endsection
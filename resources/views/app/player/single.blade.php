@extends('app')

@section('title', $player->name.' - '.trans('menu.players'))

@section('content')
    {!! Form::model($player, [
        'url' => $readonly ? 'dont/do/this' : 'app/player/edit/'.$player->getKey(),
    ]) !!}
    <div class="panel @if($readonly) panel-success @else panel-warning @endif">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $player->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    {!! Form::text('name', null, [
                        'label' => trans('messages.name'),
                        'readonly' => true,
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::text('playerid', null, [
                        'label' => trans('messages.player_id'),
                        'readonly' => true,
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                @can('edit-money', $player)
                <div class="col-md-3">
                    {!! Form::number('cash', null, [
                        'label' => trans('messages.cash'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-money', $player),
                        'errors' => $errors->get('cash'),
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('bankacc', null, [
                        'label' => trans('messages.bankacc'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-money', $player),
                        'errors' => $errors->get('bankacc'),
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('manipulate_bankacc', null, [
                        'label' => trans('messages.manipulate_bankacc'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-money', $player),
                        'errors' => $errors->get('manipulate_bankacc'),
                    ]) !!}
                </div>
                @endcan
                <div class="clearfix"></div>
                <div class="col-md-3">
                    {!! Form::select('coplevel', trans('messages.coplevel'), null, [
                        'label' => trans('messages.cop'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-cop', $player),
                        'errors' => $errors->get('coplevel'),
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::select('mediclevel', trans('messages.mediclevel'), null, [
                        'label' => trans('messages.medic'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-medic', $player),
                        'errors' => $errors->get('mediclevel'),
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::select('ataclevel', trans('messages.ataclevel'), null, [
                        'label' => trans('messages.atac'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-atac', $player),
                        'errors' => $errors->get('ataclevel'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    {!! Form::number('adminlevel', null, [
                        'label' => trans('messages.admin'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-admin', $player),
                        'errors' => $errors->get('adminlevel'),
                    ]) !!}
                </div>
                <div class="col-md-3">
                    {!! Form::number('donatorlvl', null, [
                        'label' => trans('messages.donator'),
                        'readonly' => $readonly || !\Auth::User()->can('edit-donator', $player),
                        'errors' => $errors->get('donatorlvl'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <label>{{ trans('messages.civlicenses') }}</label>
                    <ul class="list-inline">
                        @foreach($player->civ_licenses as $license)
                            <li>
                                <p>
                                    @if(!$readonly && \Auth::User()->can('edit-civ', $player))
                                        <label for="civ_licenses-{{ $license[0] }}" class="cursor-pointer license label @if($license[1]) label-success @else label-dark @endif">
                                            {!! Form::hidden('civ_licenses['.$license[0].']', ($license[1] ? 1 : 0)) !!}
                                            {{ trans('licenses.'.$license[0]) }}
                                        </label>
                                    @else
                                        <span class="label @if($license[1]) label-success @else label-dark @endif">
                                            {{ trans('licenses.'.$license[0]) }}
                                        </span>
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if($player->coplevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.coplicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($player->cop_licenses as $license)
                                <li>
                                    <p>
                                        @if(!$readonly && \Auth::User()->can('edit-cop', $player))
                                            <label for="cop_licenses-{{ $license[0] }}" class="cursor-pointer license label @if($license[1]) label-success @else label-dark @endif">
                                                {!! Form::hidden('cop_licenses['.$license[0].']', ($license[1] ? 1 : 0)) !!}
                                                {{ trans('licenses.'.$license[0]) }}
                                            </label>
                                        @else
                                            <span class="label @if($license[1]) label-success @else label-dark @endif">
                                                {{ trans('licenses.'.$license[0]) }}
                                            </span>
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($player->mediclevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.mediclicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($player->med_licenses as $license)
                                <li>
                                    <p>
                                        @if(!$readonly && \Auth::User()->can('edit-medic', $player))
                                            <label for="med_licenses-{{ $license[0] }}" class="cursor-pointer license label @if($license[1]) label-success @else label-dark @endif">
                                                {!! Form::hidden('med_licenses['.$license[0].']', ($license[1] ? 1 : 0)) !!}
                                                {{ trans('licenses.'.$license[0]) }}
                                            </label>
                                        @else
                                            <span class="label @if($license[1]) label-success @else label-dark @endif">
                                                {{ trans('licenses.'.$license[0]) }}
                                            </span>
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($player->ataclevel > 0)
                    <div class="col-md-12">
                        <label>{{ trans('messages.ataclicenses') }}</label>
                        <ul class="list-inline">
                            @foreach($player->atac_licenses as $license)
                                <li>
                                    <p>
                                        @if(!$readonly && \Auth::User()->can('edit-atac', $player))
                                            <label for="med_licenses-{{ $license[0] }}" class="cursor-pointer license label @if($license[1]) label-success @else label-dark @endif">
                                                {!! Form::hidden('atac_licenses['.$license[0].']', ($license[1] ? 1 : 0)) !!}
                                                {{ trans('licenses.'.$license[0]) }}
                                            </label>
                                        @else
                                            <span class="label @if($license[1]) label-success @else label-dark @endif">
                                                {{ trans('licenses.'.$license[0]) }}
                                            </span>
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!$readonly)
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

{{--    {{ dump($player->skills) }}--}}

    @include('partials.revisions', ['model' => $player])
@endsection
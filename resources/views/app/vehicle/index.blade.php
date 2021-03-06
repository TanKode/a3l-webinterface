@extends('app')

@section('title', trans('menu.vehicles'))

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.vehicles') }}</span>
        </div>
        <div class="margin-top-20 margin-horizontal-20">
            {!! Form::text('datatable-search', is_null($player) ? '' : 'pid='.$player->pid.';', [
                'icon' => 'wh-search',
                'placeholder' => 'pid=1234;side=civ;type=car;active=0;alive=1;classname=C_Kart_01_Blu_F;'
            ]) !!}
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget" id="datatable-vehicle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.side') }}</th>
                    <th>{{ trans('messages.type') }}</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.classname') }}</th>
                    <th>{{ trans('messages.alive') }}</th>
                    <th>{{ trans('messages.active') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
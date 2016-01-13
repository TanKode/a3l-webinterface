@extends('app')

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.players') }}</span>
        </div>
        <div class="margin-top-20 margin-horizontal-20">
            {!! Form::text('datatable-search', '', [
                'icon' => 'wh-search'
            ]) !!}
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.money') }}</th>
                    <th>{{ trans('messages.cop') }}</th>
                    <th>{{ trans('messages.medic') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player->getKey() }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->playerid }}</td>
                        <td>{{ \Formatter::money($player->total_money) }}</td>
                        <td>{{ trans('messages.coplevel.'.$player->coplevel) }}</td>
                        <td>{{ trans('messages.mediclevel.'.$player->mediclevel) }}</td>

                        <td>
                            <div class="btn-group pull-right">
                                @can('view', $player)
                                    <a href="{{ url('app/player/'.$player->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-eye-view"></i></a>
                                @endcan
                                @can('edit', $player)
                                    <a href="{{ url('app/player/edit/'.$player->getKey()) }}" class="btn btn-pure btn-icon btn-warning"><i class="icon wh-edit"></i></a>
                                @endcan
                                @can('delete', $player)
                                    <a href="{{ url('app/player/delete/'.$player->getKey()) }}" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>
                                @endcan
                                @if($player->hasUser())
                                    @can('view', $player->user)
                                        <a href="{{ url('app/user/'.$player->user->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-user"></i></a>
                                    @endcan
                                @endif
                                @can('view', \App\Vehicle::class)
                                    <a href="{{ url('app/vehicle/?player='.$player->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-automobile-car"></i></a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
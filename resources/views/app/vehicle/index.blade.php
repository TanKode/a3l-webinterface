@extends('app')

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.vehicles') }}</span>
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
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.type') }}</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.classname') }}</th>
                    <th>{{ trans('messages.alive') }}</th>
                    <th>{{ trans('messages.active') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->getKey() }}</td>
                        <td>{{ $vehicle->pid }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->display_name }}</td>
                        <td>{{ $vehicle->classname }}</td>
                        <td>{{ $vehicle->alive }}</td>
                        <td>{{ $vehicle->active }}</td>

                        <td>
                            <div class="btn-group pull-right">
                                @can('view', $vehicle)
                                    <a href="{{ url('app/vehicle/'.$vehicle->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-eye-view"></i></a>
                                @endcan
                                @can('edit', $vehicle)
                                    <a href="{{ url('app/vehicle/edit/'.$vehicle->getKey()) }}" class="btn btn-pure btn-icon btn-warning"><i class="icon wh-edit"></i></a>
                                @endcan
                                @can('delete', $vehicle)
                                    <a href="{{ url('app/vehicle/delete/'.$vehicle->getKey()) }}" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>
                                @endcan
                                @can('view', $vehicle->owner)
                                    <a href="{{ url('app/player/'.$vehicle->owner->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-boardgame"></i></a>
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
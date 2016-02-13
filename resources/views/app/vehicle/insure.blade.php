@extends('app')

@section('content')
    {!! Form::open([
        'url' => 'app/vehicle/insure',
    ]) !!}
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h4 class="panel-title">{{ \Auth::User()->player->name }}'s {{ trans('messages.vehicle_insurance') }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    {!! Form::select('vehicle', $vehicles, null, [
                        'label' => trans('messages.vehicle'),
                        'errors' => $errors->get('vehicle'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    {!! Form::submit(trans('messages.insure'), [
                        'class' => 'btn-warning pull-right',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('messages.insured_vehicles') }}</span>
        </div>
        <div class="margin-top-20 margin-horizontal-20">
            {!! Form::text('datatable-search', '', [
                'icon' => 'wh-search',
            ]) !!}
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.side') }}</th>
                    <th>{{ trans('messages.type') }}</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.classname') }}</th>
                    <th>{{ trans('messages.alive') }}</th>
                    <th>{{ trans('messages.active') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($insuredVehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->getKey() }}</td>
                        <td>{{ $vehicle->side }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->display_name }}</td>
                        <td>{{ $vehicle->classname }}</td>
                        <td>{{ trans('messages.confirms.'.$vehicle->alive) }}</td>
                        <td>{{ trans('messages.confirms.'.$vehicle->active) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
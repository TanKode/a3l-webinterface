@extends('app')

@section('title', $vehicle->display_name.' - '.$vehicle->owner->name.' - '.trans('menu.vehicles'))

@section('content')
    {!! Form::model($vehicle, [
        'url' => $readonly ? 'dont/do/this' : 'app/vehicle/edit/'.$vehicle->getKey(),
    ]) !!}
    <div class="panel @if($readonly) panel-success @else panel-warning @endif">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $vehicle->owner->name }}'s {{ $vehicle->display_name }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    {!! Form::text('side', null, [
                        'label' => trans('messages.side'),
                        'readonly' => true,
                        'errors' => $errors->get('side'),
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::text('type', null, [
                        'label' => trans('messages.type'),
                        'readonly' => true,
                        'errors' => $errors->get('type'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4">
                    {!! Form::text('pid', null, [
                        'label' => trans('messages.player_id'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('pid'),
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::text('classname', null, [
                        'label' => trans('messages.classname'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('classname'),
                    ]) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('alive', trans('messages.confirms'), null, [
                        'label' => trans('messages.alive'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('alive'),
                    ]) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('active', trans('messages.confirms'), null, [
                        'label' => trans('messages.active'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('active'),
                    ]) !!}
                </div>
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

    @include('partials.revisions', ['model' => $vehicle])
@endsection

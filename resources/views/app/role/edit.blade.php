@extends('app')

@section('title', 'Rolle bearbeiten')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($role, ['url' => 'app/role/update/'.$role->id, 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::text('name', null, ['label' => 'Name', 'disabled' => true]) !!}
            </div>
            <div class="col-md-3">
                {!! Form::selectpicker('abilities[]', $abilities, $role->abilities()->lists('id')->toArray(), ['label' => 'Berechtigungen', 'multiple' => true]) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
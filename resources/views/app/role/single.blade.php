@extends('app')

@section('content')
    {!! Form::model($role, [
        'url' => $readonly ? 'dont/do/this' : 'app/role/edit/'.$role->getKey(),
    ]) !!}
    <div class="panel @if($readonly) panel-success @else panel-warning @endif">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $role->name }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    {!! Form::text('display_name', null, [
                        'label' => trans('messages.name'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('display_name'),
                    ]) !!}
                </div>
                <div class="col-md-8">
                    {!! Form::multiselect('ability[]', $abilities, null, [
                        'label' => trans('messages.name'),
                        'readonly' => $readonly,
                        'errors' => $errors->get('abilites'),
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

    @include('partials.revisions', ['model' => $role])
@endsection
@extends('app')

@section('title', 'Einstellungen')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => 'app/setting/store', 'class' => 'row']) !!}
                <div class="col-md-4">
                    {!! Form::text('key') !!}
                </div>
                <div class="col-md-4">
                    {!! Form::text('value') !!}
                </div>
                <div class="col-md-2">
                    {!! Form::submit('speichern', ['class' => 'btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
            @foreach($settings as $setting)
                {!! Form::open(['url' => 'app/setting/create', 'class' => 'row']) !!}
                <div class="col-md-4">
                    <strong>{{ $setting->key }}</strong>
                </div>
                <div class="col-md-4">
                    {!! Form::text('value', $setting->value) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::submit('speichern', ['class' => 'btn-primary btn-block']) !!}
                </div>
                <div class="col-md-2">
                    <a href="{{ url('app/setting/delete/' . $setting->id) }}" class="btn btn-danger btn-block">löschen</a>
                </div>
                {!! Form::close() !!}
            @endforeach
        </div>
    </div>
@endsection
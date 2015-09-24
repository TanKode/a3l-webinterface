@extends('app')

@section('title', 'Changelog bearbeiten')

@section('content')
    {!! Form::model($changelog, ['url' => 'app/changelog/update/'.$changelog->id, 'class' => 'panel']) !!}
    <div class="panel-heading">
        {!! Form::text('title', null, ['placeholder' => 'Titel ...', 'class' => 'no-border input-lg padding-horizontal-30', 'container' => false]) !!}
    </div>
    <div class="panel-body">
        {!! Form::textarea('content', null, ['placeholder' => 'Changelog ...', 'class' => 'no-border', 'data-provide' => 'markdown', 'data-iconlibrary' => 'fa']) !!}
    </div>
    <div class="panel-footer clearfix">
        {!! Form::submit('veröffentlichen', ['class' => 'btn-primary pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection
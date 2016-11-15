@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        {!! Form::open([
            'url' => 'app/forum/category/'.$category->getKey().'/thread/create',
        ]) !!}
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{{ trans('forum::threads.new_thread') }} - {{ $category->title }}</h3>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::text('title', null, [
                            'label' => trans('forum::general.title'),
                            'errors' => $errors->get('title'),
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::textarea('content', null, [
                            'label' => trans('forum::general.content'),
                            'errors' => $errors->get('content'),
                            'rows' => 5,
                            'class' => 'markdown',
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        @include('partials.twemoji')
                    </div>
                    <div class="col-md-12">
                        {!! Form::submit(trans('messages.save'), [
                            'class' => 'btn-warning pull-right',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        {!! Form::model($post, [
            'url' => 'app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/post/'.$post->getKey().'/edit',
        ]) !!}
        <section class="panel panel-alt4">
            <header class="panel-heading">
                <h3 class="panel-title">{{ trans('forum::posts.edit') }} - {{ $thread->title }}</h3>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::textarea('content', stripslashes($post->content), [
                            'label' => trans('forum::general.content'),
                            'errors' => $errors->get('content'),
                            'rows' => 5,
                            'class' => 'markdown',
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        @include('partials.md_help')
                        @include('partials.twemoji')
                    </div>
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey()) }}" class="btn btn-default">{{ trans('forum::general.cancel') }}</a>
                            {!! Form::submit(trans('messages.save'), [
                                'class' => 'btn-warning',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {!! Form::close() !!}
    </div>
@endsection
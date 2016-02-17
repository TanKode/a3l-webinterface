@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        <section class="panel">
            <header class="panel-heading clearfix">
                <div class="btn-group pull-right">
                    @can('edit', $thread)
                    @if($thread->pinned)
                        <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/unpin') }}" class="btn btn-warning">{{ trans('forum::threads.unpin') }}</a>
                    @else
                        <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/pin') }}" class="btn btn-warning">{{ trans('forum::threads.pin') }}</a>
                    @endif
                    @endcan
                    @can('delete', $thread)
                        <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/delete') }}" class="btn btn-danger">{{ trans('forum::general.delete') }}</a>
                    @endcan
                </div>
                <div class="pull-left">
                    <h3 class="panel-title">{{ $thread->title }}</h3>
                </div>
            </header>
            @foreach($thread->postsPaginated as $post)
                @if(is_null($post->deleted_at))
                    <article>
                        <header class="media padding-20 bg-grey-200">
                            <div class="media-left">
                                <img src="{{ $post->author->avatar(50) }}" class="img-circle" />
                            </div>
                            <div class="media-body">
                                <div class="pull-left">
                                    <strong>{{ $post->author->name }}</strong>
                                    @if($post->author->hasPlayer())
                                        <small>
                                            aka {{ $post->author->player->name }}
                                        </small>
                                    @endif
                                    <p>
                                        {{ $post->posted }}
                                        @if($post->hasBeenUpdated())
                                            ({{ $post->updated }})
                                        @endif
                                    </p>
                                </div>
                                <div class="pull-right">
                                    <div class="btn-group pull-right">
                                        @can('edit', $post)
                                            <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/post/'.$post->getKey().'/edit') }}" class="btn btn-warning">{{ trans('forum::posts.edit') }}</a>
                                        @endcan
                                        @can('delete', $post)
                                            <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/post/'.$post->getKey().'/delete') }}" class="btn btn-danger">{{ trans('forum::general.delete') }}</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </header>
                        <section class="padding-20">
                            {!! \MarkExtra::parse($post->content) !!}
                        </section>
                    </article>
                @endif
            @endforeach
            @if($thread->postsPaginated->lastPage() > 1)
            <footer class="panel-footer">
                {!! $thread->postsPaginated->render() !!}
            </footer>
            @endif
        </section>

        {!! Form::open([
            'url' => 'app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/reply',
        ]) !!}
        <section class="panel panel-alt4">
            <header class="panel-heading">
                <h3 class="panel-title">{{ trans('forum::general.new_reply') }} - {{ $thread->title }}</h3>
            </header>
            <div class="panel-body">
                <div class="row">
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
        </section>
        {!! Form::close() !!}
    </div>
@endsection
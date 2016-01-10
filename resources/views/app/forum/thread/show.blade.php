@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        <section class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{{ $thread->title }}</h3>
            </header>
            @foreach($thread->postsPaginated as $post)
            <article>
                <header class="media padding-20 bg-grey-200">
                    <div class="media-left">
                        <img src="{{ $post->author->avatar(50) }}" class="img-circle" />
                    </div>
                    <div class="media-body">
                        <strong>{{ $post->author->name }}</strong>
                        <p>
                            {{ $post->posted }}
                            @if($post->hasBeenUpdated())
                                ({{ $post->updated }})
                            @endif
                        </p>
                    </div>
                </header>
                <section class="padding-20">
                    {!! \MarkExtra::parse($post->content) !!}
                </section>
            </article>
            @endforeach
            <footer class="panel-footer">
                {!! $thread->postsPaginated->render() !!}
            </footer>
        </section>

        {!! Form::open([
            'url' => 'app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/reply',
        ]) !!}
        <section class="panel">
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
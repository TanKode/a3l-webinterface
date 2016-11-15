@extends('wordpress')

@section('title')
    @if(!is_null($category))
        {{ $category->name }} -
    @endif
    Blog
@endsection

@section('content')
<div class="row masonry-container">
    @foreach($posts as $post)
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            <article class="panel">
                @include('wordpress.partials.post-media')
                @include('wordpress.partials.post-header')
                @include('wordpress.partials.post-excerpt')
                <footer>
                    <a href="{{ url('blog/'.$post->post_name) }}" class="btn btn-primary btn-block">{{ trans('wordpress.read_more', [
                        'title' => get_the_title($post),
                    ]) }}</a>
                </footer>
            </article>
        </div>
    @endforeach
</div>
@endsection
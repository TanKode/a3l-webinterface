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
@if(get_post_format($post) == 'video')
    @if(!empty(array_get(get_post_custom_values('youtube', $post->ID), 0, '')))
        <div class="embed-responsive embed-responsive-16by9">
            <iframe width="1920" height="1080" src="{{ array_get(get_post_custom_values('youtube', $post->ID), 0, '') }}" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
        </div>
    @endif
@else
    @if(has_post_thumbnail($post))
        {!! get_the_post_thumbnail($post, 'full', [
            'alt' => get_the_title(),
            'class' => 'img-responsive',
         ]) !!}
    @endif
@endif
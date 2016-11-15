@if(get_post_format($post) == 'video' && !empty(array_get(get_post_custom_values('youtube', $post->ID), 0, '')))
    <div class="embed-responsive embed-responsive-16by9">
        <iframe width="1920" height="1080" src="{{ array_get(get_post_custom_values('youtube', $post->ID), 0, '') }}" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
    </div>
@elseif(get_post_format($post) == 'quote' && !empty(array_get(get_post_custom_values('quote_content', $post->ID), 0, '')))
    <blockquote class="bg-grey-800 border-primary white margin-bottom-0">
        <p>{{ array_get(get_post_custom_values('quote_content', $post->ID), 0, '') }}</p>
        @if(!empty(array_get(get_post_custom_values('quote_author', $post->ID), 0, '')))
            <footer>{{ array_get(get_post_custom_values('quote_author', $post->ID), 0, '') }}</footer>
        @endif
    </blockquote>
@elseif(get_post_format($post) == 'status' && !empty(array_get(get_post_custom_values('state_default', $post->ID), 0, '')))
    <blockquote class="bg-grey-800 border-primary white margin-bottom-0">
        <p>{{ array_get(get_post_custom_values('state_default', $post->ID), 0, '') }}</p>
    </blockquote>
@elseif(get_post_format($post) == 'status' && !empty(array_get(get_post_custom_values('state_error', $post->ID), 0, '')))
    <blockquote class="bg-grey-800 border-danger white margin-bottom-0">
        <p>{{ array_get(get_post_custom_values('state_error', $post->ID), 0, '') }}</p>
    </blockquote>
@elseif(get_post_format($post) == 'status' && !empty(array_get(get_post_custom_values('state_success', $post->ID), 0, '')))
    <blockquote class="bg-grey-800 border-success white margin-bottom-0">
        <p>{{ array_get(get_post_custom_values('state_success', $post->ID), 0, '') }}</p>
    </blockquote>
@else
    @if(has_post_thumbnail($post))
        {!! get_the_post_thumbnail($post, 'full', [
            'alt' => get_the_title(),
            'class' => 'img-responsive',
         ]) !!}
    @endif
@endif
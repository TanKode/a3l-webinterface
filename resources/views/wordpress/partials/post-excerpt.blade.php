<section class="padding-horizontal-20 padding-bottom-30">
    @if(empty($post->post_excerpt))
        @if(strlen($post->post_content) > 200 && str_contains($post->post_content, ' '))
            {{ strip_tags(substr($post->post_content, 0, strpos($post->post_content, ' ', 200))) }} ...
        @else
            {{ strip_tags($post->post_content) }}
        @endif
    @else
        {{ $post->post_excerpt }}
    @endif
</section>
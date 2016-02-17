<header class="panel-heading">
    <h3 class="panel-title">
        @if(get_post_format($post) == 'video')
            <i class="icon wh-video"></i>
        @else
            <i class="icon wh-post"></i>
        @endif
        {{ get_the_title($post) }}
    </h3>
    <ul class="list-inline">
        <li>{{ get_the_author_meta('display_name', $post->post_author) }}</li>
        <li>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date_gmt, 'UTC')->setTimezone(config('app.timezone'))->diffForHumans() }}</li>
        @foreach(get_the_category($post->ID) as $category)
            <li>{{ $category->name }}</li>
        @endforeach
    </ul>
</header>
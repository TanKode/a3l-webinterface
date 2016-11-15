<header class="panel-heading">
    <h3 class="panel-title">
        @if(get_post_format($post) == 'video')
            <i class="icon wh-video"></i>
        @elseif(get_post_format($post) == 'quote')
            <i class="icon wh-quote"></i>
        @elseif(get_post_format($post) == 'status')
            <i class="icon wh-cog"></i>
        @elseif(get_post_format($post) == 'image')
            <i class="icon wh-picture"></i>
        @else
            <i class="icon wh-post"></i>
        @endif
        {{ get_the_title($post) }}
    </h3>
    <ul class="list-inline margin-bottom-0">
        <li>{{ get_the_author_meta('display_name', $post->post_author) }}</li>
        <li>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date_gmt, 'UTC')->setTimezone(config('app.timezone'))->diffForHumans() }}</li>
        @foreach(get_the_category($post->ID) as $category)
            <li>
                <a href="{{ url('blog/cat/'.$category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</header>
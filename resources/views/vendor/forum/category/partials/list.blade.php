<tr>
    <td {{ $category->threadsEnabled ? '' : 'colspan=5'}}>
        <a href="{{ \Forum::route('category.show', $category) }}">{{ $category->title }}</a>
        @if(!empty($category->description))
            <p class="text-muted">{{ $category->description }}</p>
        @endif
    </td>
    @if ($category->threadsEnabled)
        <td>{{ $category->threadCount }}</td>
        <td>{{ $category->postCount }}</td>
        <td>
            @if($category->newestThread)
                <a href="{{ \Forum::route('forum.thread.show', $category->newestThread) }}">
                    {{ $category->newestThread->title }}
                    ({{ $category->newestThread->authorName }})
                </a>
            @endif
        </td>
        <td>
            @if($category->latestActiveThread)
                <a href="{{ \Forum::route('forum.post.show', $category->latestActiveThread->lastPost) }}">
                    {{ $category->latestActiveThread->title }}
                    ({{ $category->latestActiveThread->lastPost->authorName }})
                </a>
            @endif
        </td>
    @endif
</tr>

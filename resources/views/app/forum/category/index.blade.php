@extends('app.forum.master')

@section('content')
    <div class="padding-35">
    @foreach($categories as $category)
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{{ $category->title }}</h3>
                @if(!empty($category->description))
                    <p class="text-muted">{!! \Markdown::parse($category->description) !!}</p>
                @endif
            </header>
            @if(!$category->children->isEmpty())
                <div class="padding-horizontal-15 clearfix">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ trans_choice('forum::categories.category', 1) }}</th>
                            <th class="col-md-2">{{ trans_choice('forum::threads.thread', 2) }}</th>
                            <th class="col-md-2">{{ trans_choice('forum::posts.post', 2) }}</th>
                            <th class="col-md-2">{{ trans('forum::threads.newest') }}</th>
                            <th class="col-md-2">{{ trans('forum::posts.last') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($category->children as $subcategory)
                            <tr>
                                <td>
                                    <a href="{{ url('app/forum/category/' . $subcategory->getKey()) }}">{{ $subcategory->title }}</a>
                                    @if(!empty($subcategory->description))
                                        <p class="text-muted">{!! \Markdown::parse($subcategory->description) !!}</p>
                                    @endif
                                </td>
                                @if ($subcategory->threadsEnabled)
                                    <td>{{ $subcategory->threadCount }}</td>
                                    <td>{{ $subcategory->postCount }}</td>
                                    <td>
                                        @if($subcategory->newestThread)
                                            <a href="{{ \Forum::route('forum.thread.show', $subcategory->newestThread) }}">
                                                {{ $subcategory->newestThread->title }}
                                                ({{ $subcategory->newestThread->authorName }})
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subcategory->latestActiveThread)
                                            <a href="{{ \Forum::route('forum.post.show', $subcategory->latestActiveThread->lastPost) }}">
                                                {{ $subcategory->latestActiveThread->title }}
                                                ({{ $subcategory->latestActiveThread->lastPost->authorName }})
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endforeach
    </div>
@endsection
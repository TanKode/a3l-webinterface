@extends('app.forum.master')

@section('content')
    <div class="padding-35">
    @foreach($categories as $category)
        @can('view', $category)
        <div class="panel">
            <header class="panel-heading">
                <div class="btn-group pull-right">
                    @can('edit', $category)
                    <a href="{{ url('app/forum/category/edit/'.$category->getKey()) }}" class="btn btn-warning">{{ trans('forum::general.edit') }}</a>
                    @endcan
                    @can('delete', $category)
                    <a href="{{ url('app/forum/category/delete/'.$category->getKey()) }}" class="btn btn-danger">{{ trans('forum::general.delete') }}</a>
                    @endcan
                </div>
                <div class="pull-left">
                <h3 class="panel-title">{{ $category->title }}</h3>
                @if(!empty($category->description))
                    <div class="text-muted">{!! \MarkExtra::parse($category->description) !!}</div>
                @endif
                </div>
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($category->children as $subcategory)
                            @can('view', $subcategory)
                            <tr>
                                <td>
                                    <a href="{{ url('app/forum/category/' . $subcategory->getKey()) }}">{{ $subcategory->title }}</a>
                                    @if(!empty($subcategory->description))
                                        <p class="text-muted">{!! \MarkExtra::parse($subcategory->description) !!}</p>
                                    @endif
                                </td>
                                @if ($subcategory->threadsEnabled)
                                    <td>{{ $subcategory->threadCount }}</td>
                                    <td>{{ $subcategory->postCount }}</td>
                                    <td>
                                        @if($subcategory->newestThread)
                                            <a href="{{ url('app/forum/category/' . $subcategory->getKey().'/thread/'.$subcategory->newestThread->getKey()) }}">
                                                {{ $subcategory->newestThread->title }}
                                                ({{ $subcategory->newestThread->authorName }})
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @endcan
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @endcan
    @endforeach
    </div>
@endsection
@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        <div class="panel">
            <header class="panel-heading clearfix">
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
            <div class="padding-horizontal-15 clearfix">
                <table class="table table-thread">
                    <thead>
                    <tr>
                        <th>{{ trans('forum::general.subject') }}</th>
                        <th class="col-md-2 text-right">{{ trans('forum::general.replies') }}</th>
                        <th class="col-md-2 text-right">{{ trans('forum::posts.last') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!$category->threadsPaginated->isEmpty())
                        @foreach ($category->threadsPaginated as $thread)
                            <tr class="{{ $thread->trashed() ? "deleted" : "" }}">
                                <td>
                                    <span class="pull-right">
                                        @if ($thread->locked)
                                            <span class="label label-warning">{{ trans('forum::threads.locked') }}</span>
                                        @endif
                                        @if ($thread->pinned)
                                            <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
                                        @endif
                                        @if ($thread->userReadStatus && !$thread->trashed())
                                            <span class="label label-primary">{{ trans($thread->userReadStatus) }}</span>
                                        @endif
                                        @if ($thread->trashed())
                                            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
                                        @endif
                                    </span>
                                    <p class="lead">
                                        <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey()) }}">{{ $thread->title }}</a>
                                    </p>
                                </td>
                                @if ($thread->trashed())
                                    <td colspan="2">&nbsp;</td>
                                @else
                                    <td class="text-right">
                                        {{ $thread->replyCount }}
                                    </td>
                                    <td class="text-right">
                                        {{ $thread->lastPost->authorName }}
                                        <p class="text-muted">({{ $thread->lastPost->posted }})</p>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                {{ trans('forum::threads.none_found') }}
                            </td>
                            <td class="text-right" colspan="3">
                                @can ('createThreads', $category)
                                    <a href="{{ url('app/forum/category/'.$category->getKey().'/thread/create') }}">{{ trans('forum::threads.post_the_first') }}</a>
                                @endcan
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
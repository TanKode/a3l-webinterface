@extends('forum::layouts.master')

@section('title', $category->title)

@section('content')
    @if(!$category->subcategories->isEmpty())
        <div class="list-group">
            @foreach($category->subcategories as $subcategory)
                <a class="list-group-item padding-15" href="{{ $subcategory->route }}">
                    <h5 class="margin-0">
                        {{ $subcategory->title }}
                        <ul class="pull-right list-inline">
                            <li><span class="label label-dark"><i class="icon fa-comments-o"></i> {{ $subcategory->threadCount }}</span></li>
                            <li><span class="label label-dark"><i class="icon fa-comment-o"></i> {{ $subcategory->postCount }}</span></li>
                        </ul>
                    </h5>
                </a>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-xs-4">
            @if (($category->canPost && $category->subcategories->isEmpty()) || \Auth::User()->isSuperAdmin())
                <a href="{{ $category->newThreadRoute }}" class="btn btn-primary">{{ trans('forum::base.new_thread') }}</a>
            @endif
        </div>
        <div class="col-xs-8 text-right">
            {!! $category->pageLinks !!}
        </div>
    </div>

    @if(!$category->threadsPaginated->isEmpty())
        <div class="list-group">
            @foreach($category->threadsPaginated as $thread)
                <a class="list-group-item padding-15" href="{{ $thread->route }}">
                    <h5 class="margin-0">
                        @if($thread->locked)
                            <i class="icon fa-lock text-danger"></i>
                        @endif
                        @if($thread->pinned)
                            <i class="icon fa-thumb-tack text-info"></i>
                            <strong>
                        @endif
                        {{ $thread->title }}
                        @if($thread->pinned)
                            </strong>
                        @endif
                        <ul class="pull-right list-inline">
                            <li><span class="label label-dark"><i class="icon fa-comment-o"></i> {{ $thread->replyCount }}</span></li>
                            <li><span class="label label-default"><i class="icon fa-eye"></i> {{ $thread->viewCount }}</span></li>
                            <li><span class="label label-default">{{ $thread->authorName }} {{ $thread->lastPost->created_at->diffForHumans() }}</span></li>
                        </ul>
                    </h5>
                </a>
            @endforeach
        </div>
    @endif
@overwrite

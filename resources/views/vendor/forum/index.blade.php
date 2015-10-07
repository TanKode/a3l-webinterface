@extends('forum::layouts.master')

@section('title', trans('forum::base.index'))

@section('content')
    <div class="list-group">
        @foreach($categories as $category)
            <a class="list-group-item padding-15" href="{{ $category->route }}">
                <h4 class="margin-0">
                    {{ $category->title }}
                </h4>
            </a>

            @if(!$category->subcategories->isEmpty())
                @foreach($category->subcategories as $subcategory)
                    <a class="list-group-item padding-left-30 padding-15" href="{{ $subcategory->route }}">
                        <h5 class="margin-0">
                            {{ $subcategory->title }}
                            <ul class="pull-right list-inline">
                                <li><span class="label label-dark"><i class="icon fa-comments-o"></i> {{ $subcategory->threadCount }}</span></li>
                                <li><span class="label label-dark"><i class="icon fa-comment-o"></i> {{ $subcategory->postCount }}</span></li>
                            </ul>
                        </h5>
                    </a>
                @endforeach
            @endif
        @endforeach
    </div>
@overwrite

@extends('forum::master', ['category' => null])

@section('content')
    @can('createCategories')
        @include('forum::category.partials.form-create')
    @endcan

        <div class="panel">
            <table class="table table-striped">
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
                @foreach($categories as $category)
                    @include('forum::category.partials.list', ['titleClass' => 'lead'])
                    @if(!$category->children->isEmpty())
                        <tr>
                            <th colspan="5">{{ trans('forum::categories.subcategories') }}</th>
                        </tr>
                        @foreach($category->children as $subcategory)
                            @include('forum::category.partials.list', ['category' => $subcategory])
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
@stop

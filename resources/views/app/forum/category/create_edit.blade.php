@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        {!! Form::model($category, [
            'url' => $action == 'edit' ? 'app/forum/category/edit/'.$category->getKey() : 'app/forum/category/create',
        ]) !!}
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{{ trans('forum::categories.create') }}</h3>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::text('title', null, [
                            'label' => trans('forum::general.title'),
                            'errors' => $errors->get('title'),
                        ]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('category_id', \Riari\Forum\Models\Category::all()->reject(function($category) {
                            return $category->children->isEmpty();
                        })->pluck('title', 'id')->prepend(trans('forum::general.none'), '')->toArray(), null, [
                            'label' => trans_choice('forum::categories.category', 1),
                            'errors' => $errors->get('category_id'),
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::textarea('description', null, [
                            'label' => trans('forum::general.description'),
                            'errors' => $errors->get('description'),
                            'rows' => 3,
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::hidden('weight', 0) !!}
                        {!! Form::hidden('enable_threads', 1) !!}
                        {!! Form::hidden('private', 0) !!}
                        <div class="btn-group pull-right">
                            <a href="{{ url('app/forum/category/'.$category->getKey()) }}" class="btn btn-default">{{ trans('forum::general.cancel') }}</a>
                            {!! Form::submit(trans('messages.save'), [
                                'class' => 'btn-warning pull-right',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
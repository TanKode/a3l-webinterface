@extends('app.forum.master')

@section('content')
    <div class="padding-35">
        {!! Form::open([
            'route' => 'forum.category.store',
        ]) !!}
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('forum::categories.create') }}</h3>
            </div>

            <div class="create-category">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::text('title', null, [
                                'label' => trans('forum::general.title'),
                                'errors' => $errors->get('title'),
                            ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('description', null, [
                                'label' => trans('forum::general.description'),
                                'errors' => $errors->get('description'),
                            ]) !!}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category-id">{{ trans_choice('forum::categories.category', 1) }}</label>
                                <select name="category_id" id="category-id" class="form-control">
                                    <option value="">({{ trans('forum::general.none') }})</option>
                                    {{--@include('forum::category.partials.options')--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::number('weight', null, [
                                'label' => trans('forum::general.weight'),
                                'errors' => $errors->get('weight'),
                            ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::checkbox('enable_threads', 1, null, [
                                'label' => trans('forum::categories.enable_threads'),
                                'errors' => $errors->get('enable_threads'),
                            ]) !!}
                        </div>
                        <div class="col-md-8">
                            {!! Form::hidden('private', 0) !!}
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
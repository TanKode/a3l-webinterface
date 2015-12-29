@extends('app')

@section('body-class', 'am-aside')
@section('content-class', 'am-no-padding')

@section('page-head')
    @include('app.chat.partials.sidebar')
@endsection

@section('content')
    @if(is_null($display_thread))
        {!! Form::open([
            'url' => 'app/chat/create',
        ]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="padding-10">
                    {!! Form::multiselect('recipients[]', $recipients, null, [
                        'label' => trans('messages.recipients'),
                        'errors' => $errors->get('recipients'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="padding-10">
                    <div class="input-group">
                        {!! Form::text('body', null, [
                            'container' => false,
                        ]) !!}
                        <span class="input-group-btn">
                        {!! Form::submit(trans('messages.send'), [
                            'class' => 'btn-info',
                        ]) !!}
                    </span>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @else
        {!! Form::open([
            'url' => 'app/chat/' . $display_thread->getKey(),
        ]) !!}
        <div class="clearfix padding-10">
            <div class="input-group">
                {!! Form::text('body', null, [
                    'container' => false,
                ]) !!}
                <span class="input-group-btn">
                    {!! Form::submit(trans('messages.send'), [
                        'class' => 'btn-info',
                    ]) !!}
                </span>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="clearfix padding-10">
            <div class="row">
                @foreach($display_thread->messages()->orderBy('created_at', 'desc')->get() as $message)
                    <div class="col-md-8 @if($message->user->getKey() == \Auth::id()) col-md-offset-4 @endif">
                        <div class="media margin-bottom-10">
                            @if($message->user->getKey() != \Auth::id())
                                <div class="media-left">
                                    <img src="{{ $message->user->avatar(48) }}" class="img-circle" data-toggle="tooltip" data-placement="bottom" title="{{ $message->user->name }}" />
                                </div>
                            @endif
                            <div class="media-body padding-10 bg-white">
                                <small><strong>{!! $message->user->name !!}</strong></small>
                                <small class="pull-right">{{ $message->created_at->diffForHumans() }}</small>
                                <div>{!! $message->body !!}</div>
                            </div>
                            @if($message->user->getKey() == \Auth::id())
                                <div class="media-right">
                                    <img src="{{ $message->user->avatar(48) }}" class="img-circle" data-toggle="tooltip" data-placement="bottom" title="{{ $message->user->name }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
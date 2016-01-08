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
    @else
        {!! Form::open([
            'url' => 'app/chat/' . $display_thread->getKey(),
        ]) !!}
    @endif
        <div class="clearfix padding-35 padding-bottom-0">
            <div class="row">
                @if(is_null($display_thread))
                    <div class="col-md-12">
                        {!! Form::multiselect('recipients[]', $recipients, null, [
                            'label' => trans('messages.recipients'),
                            'errors' => $errors->get('recipients'),
                        ]) !!}
                    </div>
                @endif
                <div class="col-md-10 col-lg-11">
                    {!! Form::textarea('body', null, [
                        'rows' => 1,
                        'class' => 'markdown',
                    ]) !!}
                </div>
                <div class="col-md-2 col-lg-1">
                    {!! Form::submit(trans('messages.send'), [
                        'class' => 'btn-info pull-right btn-block',
                    ]) !!}
                </div>
                <div class="col-md-12">
                    @include('partials.twemoji')
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    @if(!is_null($display_thread))
        <div class="clearfix padding-35 padding-top-15">
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
                                <div>{!! \MarkExtra::parse($message->body) !!}</div>
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
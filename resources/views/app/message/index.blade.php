@extends('app')

@section('body-class', 'am-aside')
@section('content-class', 'am-no-padding')

@section('page-head')
    @include('app.message.partials.sidebar')
@endsection

@section('content')
    @if(!is_null($display_player))
        <div class="clearfix padding-35 padding-top-15">
            <div class="row">
                @foreach(\Auth::User()->player->messagesWithPlayer($display_player) as $message)
                    <div class="col-md-8 @if($message->sender->getKey() == \Auth::User()->player->getKey()) col-md-offset-4 @endif">
                        <div class="media margin-bottom-10">
                            <div class="media-body padding-10 bg-white">
                                <small><strong>{!! $message->sender->name !!}</strong></small>
                                <small class="pull-right">{{ $message->time->diffForHumans() }}</small>
                                <div>{!! $message->message !!}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
@extends('errors')

@section('title', 500)

@section('content')
    <div class="text-center">
        <h1 class="white font-size-80"><i class="icon wh-erroralt text-danger"></i> 500</h1>
        <h2 class="white">{{ trans('messages.errors.500') }}</h2>
    </div>
@endsection
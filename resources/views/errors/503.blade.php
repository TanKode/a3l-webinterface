@extends('errors')

@section('title', 503)

@section('content')
    <div class="text-center">
        <h1 class="white font-size-80"><i class="icon wh-wrench text-danger"></i> 503</h1>
        <h2 class="white">{{ trans('messages.errors.503') }}</h2>

        <div class="text-center">
            @include('partials.footer')
        </div>
    </div>
@endsection
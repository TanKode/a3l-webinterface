@extends('errors')

@section('content')
    <div class="text-center">
        <h1 class="white font-size-80">403</h1>
        <h2 class="white">{{ trans('messages.errors.403') }}</h2>

        <p>
            <a href="{{ url('app/dashboard') }}" class="btn btn-primary btn-block btn-lg">{{ trans('messages.back') }}</a>
        </p>

        <div class="text-center">
            @include('partials.footer')
        </div>
    </div>
@endsection
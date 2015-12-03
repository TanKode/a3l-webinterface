@extends('app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @if(Auth::User()->player != null)
        @include('home.widgets.profile')
    @endif
	@if(count(\Setting::get('info')) > 0)
        @include('home.widgets.info')
	@endif
    @include('home.widgets.statistic')
</div>
@endsection
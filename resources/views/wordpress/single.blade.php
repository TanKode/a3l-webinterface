@extends('wordpress')

@section('title', get_the_title($post) . ' - Blog')

@section('content')
    <div class="container">
        <article class="panel">
            @include('wordpress.partials.post-media')
            @include('wordpress.partials.post-header')
            @include('wordpress.partials.post-content')
        </article>
    </div>
@endsection
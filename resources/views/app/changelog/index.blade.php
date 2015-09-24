@extends('app')

@section('title', 'Changelog')

@section('content')
    @if(\Auth::User()->can('manage', \App\Changelog::class))
        {!! Form::open(['url' => 'app/changelog/store', 'class' => 'panel']) !!}
            <div class="panel-heading">
                {!! Form::text('title', null, ['placeholder' => 'Titel ...', 'class' => 'no-border input-lg padding-horizontal-30', 'container' => false]) !!}
            </div>
            <div class="panel-body">
                {!! Form::textarea('content', null, ['placeholder' => 'Changelog ...', 'class' => 'no-border', 'data-provide' => 'markdown', 'data-iconlibrary' => 'fa']) !!}
                <p>
                    <code><i class="icon fa-bug text-warning"></i> [BUG] || [BUGFIX]</code>
                    <code><i class="icon fa-level-up text-success"></i> [UPDATE] || [UPGRADE]</code>
                    <code><i class="icon fa-plus text-success"></i> [ADD] || [PLUS]</code>
                    <code><i class="icon fa-minus text-danger"></i> [REMOVE] || [MINUS]</code>
                </p>
            </div>
            <div class="panel-footer clearfix">
                {!! Form::submit('veröffentlichen', ['class' => 'btn-primary pull-right']) !!}
            </div>
        {!! Form::close() !!}
    @endif
    @foreach($changelogs as $changelog)
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">{{ $changelog->title }}</h3>
                @if(\Auth::User()->can('manage', \App\Changelog::class))
                <div class="panel-actions">
                    <a href="{{ url('app/changelog/delete/'.$changelog->id) }}" class="panel-action icon fa-trash-o"></a>
                    <a href="{{ url('app/changelog/edit/'.$changelog->id) }}" class="panel-action icon fa-pencil"></a>
                </div>
                @endif
            </header>
            <div class="panel-body max-height-250 scrollable scrollable-shadow is-enabled scrollable-vertical" data-plugin="scrollable" data-skin="scrollable-shadow">
                <div data-role="container" class="scrollable-container">
                    <article data-role="content" class="scrollable-content">
                        {!! \MarkExtra::defaultTransform($changelog->content) !!}
                    </article>
                </div>
                <div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide" draggable="false"><div class="scrollable-bar-handle"></div></div>
            </div>
        </div>
    @endforeach
@endsection
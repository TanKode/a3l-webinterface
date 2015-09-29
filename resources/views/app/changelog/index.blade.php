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
        <div class="panel is-collapse">
            <header class="panel-heading">
                <h3 class="panel-title">
                    {{ $changelog->title }}
                    <small>{{ $changelog->created_at->format('d.m.Y') }}</small>
                </h3>

                <div class="panel-actions">
                    @if(\Auth::User()->can('manage', \App\Changelog::class))
                    <a href="{{ url('app/changelog/delete/'.$changelog->id) }}" class="panel-action icon fa-trash-o"></a>
                    <a href="{{ url('app/changelog/edit/'.$changelog->id) }}" class="panel-action icon fa-pencil"></a>
                    @endif
                    <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
                </div>
            </header>
            <div class="panel-body">
                <div data-role="container" class="scrollable-container">
                    <article data-role="content" class="scrollable-content">
                        {!! \MarkExtra::defaultTransform($changelog->content) !!}
                    </article>
                </div>
            </div>
        </div>
    @endforeach
@endsection
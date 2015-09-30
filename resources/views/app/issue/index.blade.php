@extends('app')

@section('title', 'Ticket Übersicht')

@section('content')
    <div class="panel is-collapse">
        <div class="panel-heading">
            <h3 class="panel-title">neues Ticket anlegen</h3>
            <div class="panel-actions">
                <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => 'app/issue/store', 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::selectpicker('project_id', [11 => 'Altis Life', 18 => 'Exile', 16 => 'Webseite'], null, ['label' => 'Projekt']) !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('title', null, ['label' => 'Überschrift']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::textarea('description', null, ['label' => 'Beschreibung', 'rows' => 3]) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2" data-plugin="masonry">
    @foreach($issues as $issue)
        <li class="masonry-item">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title">
                        @if($issue['state'] == 'closed')
                            <i class="icon text-success fa-close"></i>
                        @else
                            <i class="icon text-warning fa-circle"></i>
                        @endif
                        {{ $issue['title'] }}
                    </h3>
                </header>
                <article class="panel-body">
                    {!! \MarkExtra::defaultTransform($issue['description']) !!}
                </article>
                <section class="panel-footer">
                    <ul class="list-inline">
                        <li><span class="label label-info">{{ \GitLab::api('projects')->show($issue['project_id'])['name'] }}</span></li>
                        <li><span class="label label-info">{{ $issue['milestone']['title'] }}</span></li>
                        @foreach($issue['labels'] as $label)
                            <li><span class="label label-dark">{{ $label }}</span></li>
                        @endforeach
                    </ul>
                </section>
            </div>
        </li>
    @endforeach
    </ul>
@endsection
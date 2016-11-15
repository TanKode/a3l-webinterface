@extends('app')

@section('title', trans('menu.backups'))

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.backups') }}</span>
        </div>
        <div class="margin-top-20 margin-horizontal-20">
            {!! Form::text('datatable-search', '', [
                'icon' => 'wh-search'
            ]) !!}
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget datatable" data-order='[[1,"desc"]]'>
                <thead>
                <tr>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.date') }}</th>
                    <th>{{ trans('messages.size') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($backups as $backup)
                    <tr>
                        <td>{{ $backup['filename'] }}</td>
                        <td>{{ $backup['carbon']->setTimezone(config('app.timezone')) }}</td>
                        <td>{{ $backup['display_size'] }} MB</td>
                        <td>
                            <div class="btn-group pull-right">
                                @can('download-backups')
                                    <a href="{{ url('app/backup/download/?filename='.$backup['basename']) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-download-alt"></i></a>
                                @endcan
                                @can('delete-backups')
                                    <a href="{{ url('app/backup/delete/?filename='.$backup['basename']) }}" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@extends('app')

@section('title', trans('menu.roles'))

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools">
                <a href="{{ url('app/role/create') }}"><i class="icon wh-selectionadd"></i></a>
            </div>
            <span class="title">{{ trans('menu.roles') }}</span>
        </div>
        <div class="margin-top-20 margin-horizontal-20">
            {!! Form::text('datatable-search', '', [
                'icon' => 'wh-search'
            ]) !!}
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.abilities') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->getKey() }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>
                            <ul class="list-inline">
                            @foreach($role->abilities as $ability)
                                <li><p><span class="label label-info font-weight-400">{{ $ability->display_name }}</span></p></li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            <div class="btn-group pull-right">
                                @if(\Auth::user()->can('view', $role))
                                    <a href="{{ url('app/role/'.$role->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-eye-view"></i></a>
                                @endif
                                @if(\Auth::user()->can('edit', $role))
                                    <a href="{{ url('app/role/edit/'.$role->getKey()) }}" class="btn btn-pure btn-icon btn-warning"><i class="icon wh-edit"></i></a>
                                @endif
                                @if(\Auth::user()->can('delete', $role))
                                    <a href="{{ url('app/role/delete/'.$role->getKey()) }}" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
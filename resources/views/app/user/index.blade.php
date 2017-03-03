@extends('app')

@section('title', trans('menu.users'))

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.users') }}</span>
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
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.email') }}</th>
                    <th>{{ trans('messages.roles') }}</th>
                    <th>{{ trans('messages.created_at') }}</th>
                    <th>{{ trans('messages.confirmed') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->getKey() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->player_id }}</td>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        <td>
                            <ul class="list-inline">
                            @foreach($user->roles as $role)
                                <li><span class="label label-info font-weight-400">{{ $role->name }}</span></li>
                            @endforeach
                            </ul>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ trans('messages.confirms.'.$user->confirmed) }}</td>
                        <td>
                            <div class="btn-group pull-right">
                                @if(\Auth::user()->can('view', $user))
                                    <a href="{{ url('app/user/'.$user->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-eye-view"></i></a>
                                @endif
                                @if(\Auth::user()->can('edit', $user))
                                    <a href="{{ url('app/user/edit/'.$user->getKey()) }}" class="btn btn-pure btn-icon btn-warning"><i class="icon wh-edit"></i></a>
                                @endif
                                @if(\Auth::user()->can('delete', $user))
                                    <a href="{{ url('app/user/delete/'.$user->getKey()) }}" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>
                                @endif
                                @if(\Auth::user()->can('view', $user->player))
                                    <a href="{{ url('app/player/'.$user->player->getKey()) }}" class="btn btn-pure btn-icon btn-success"><i class="icon wh-boardgame"></i></a>
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
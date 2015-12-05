@extends('app')

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">{{ trans('menu.users') }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-fw-widget datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.email') }}</th>
                    <th class="noindex"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->getKey() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->player_id }}</td>
                        <td>{{ $user->email }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
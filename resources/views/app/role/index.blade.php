@extends('app')

@section('title', 'Rollen Übersicht')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">@yield('title')</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped width-full dtr-inline" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th class="german">#</th>
                        <th class="german">Name</th>
                        <th class="german">Berechtigungen</th>
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if($role->name == 'super-admin')
                                    <span class="label label-danger label-outline">alle Berechtigungen</span>
                                @else
                                    <ul class="list-inline">
                                        @foreach($role->abilities as $ability)
                                            <li class="label label-default label-outline">
                                                {{ full_ability_name($ability) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                @if(\Auth::User()->canAssignRole($role->id))
                                    <a href="{{ url('app/role/edit/'.$role->id) }}" class="text-warning pull-right"><i class="icon fa-pencil"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
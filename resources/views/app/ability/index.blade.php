@extends('app')

@section('title', 'Berechtigungs Übersicht')

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
                        <th class="german">Rollen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($abilities as $ability)
                        <tr>
                            <td>{{ $ability->id }}</td>
                            <td>{{ full_ability_name($ability) }}</td>
                            <td>
                                <ul class="list-inline">
                                    @foreach($ability->roles as $role)
                                        <li class="label label-default label-outline">
                                            {{ $role->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
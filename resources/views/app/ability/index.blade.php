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
                        <th class="noindex"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($abilities as $ability)
                        <tr>
                            <td>{{ $ability->id }}</td>
                            <td>{{ $ability->name }}</td>
                            <td>
                                <ul class="list-inline pull-right">
                                    <li><a href="{{ url('app/ability/edit/'.$ability->id) }}" class="text-warning"><i class="icon fa-pencil"></i></a></li>
                                    <li><a href="{{ url('app/ability/delete/'.$ability->id) }}" class="text-danger"><i class="icon fa-trash-o"></i></a></li>
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
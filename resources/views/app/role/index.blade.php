@extends('app')

@section('title', 'Rollen Übersicht')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Rolle hinzufügen</h3>
            <div class="panel-actions">
                <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['url' => 'app/role/store/', 'class' => 'row']) !!}
            <div class="col-md-3">
                {!! Form::text('name', null, ['label' => 'Name']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::selectpicker('abilities[]', $abilities, null, ['label' => 'Berechtigungen', 'multiple' => true]) !!}
            </div>
            <div class="col-md-12">
                {!! Form::submit('speichern', ['class' => 'btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

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
                                                {{ $ability->slug }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                @if(\Auth::User()->canAssignRole($role))
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
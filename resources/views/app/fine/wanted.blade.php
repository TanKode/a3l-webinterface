@extends('app')

@section('title', trans('menu.wanted_list'))

@section('content')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <h4 class="panel-title">{{ trans('messages.fine_results') }}</h4>
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
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.player_id') }}</th>
                    <th>{{ trans('messages.fines') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wanteds as $wanted)
                    <tr>
                        <td>{{ \App\Player::pid($wanted[1])->first()->name }}</td>
                        <td>{{ $wanted[1] }}</td>
                        <td>{{ implode(', ', $wanted[2]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
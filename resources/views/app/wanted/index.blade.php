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
                    <th>{{ trans('messages.crimes') }}</th>
                    <th>{{ trans('messages.bounty') }}</th>
                    <th>{{ trans('messages.created_at') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wanteds as $wanted)
                    @if($wanted->hasPlayer())
                    <tr>
                        <td>{{ $wanted->player->name }}</td>
                        <td>{{ implode(', ', $wanted->wantedCrimes) }}</td>
                        <td>{{ \Formatter::money($wanted->wantedBounty) }}</td>
                        <td>{{ $wanted->insert_time }}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
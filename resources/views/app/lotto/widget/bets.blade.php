<div class="panel">
    <header class="panel-heading">
        <h4 class="panel-title">{{ trans('messages.bets') }}</h4>
    </header>
    <div class="margin-top-20 margin-horizontal-20">
        {!! Form::text('datatable-search', '', [
            'icon' => 'wh-search'
        ]) !!}
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-fw-widget datatable">
            <thead>
            <tr>
                <th>{{ trans('messages.user') }}</th>
                <th>{{ trans('messages.player') }}</th>
                <th>{{ trans('messages.numbers') }}</th>
                <th>{{ trans('messages.date') }}</th>
                <th>{{ trans('messages.corrects') }}</th>
                <th>{{ trans('messages.profit') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lotto->users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->player->name }} @can('view', $lotto) - {{ $user->player->playerid }} @endcan</td>
                    <td>{{ $user->pivot->numbers }}</td>
                    <td>{{ $user->pivot->created_at }}</td>
                    <td>{{ $lotto->getCorrectsByNumbers($user->pivot->numbers) }}</td>
                    <td>{{ \Formatter::money($lotto->getProfitByNumbers($user->pivot->numbers)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
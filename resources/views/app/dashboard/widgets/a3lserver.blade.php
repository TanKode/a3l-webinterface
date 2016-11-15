@if($a3lserver['online'] && $a3lserver['info'])
<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ array_get($a3lserver, 'info.HostName') }}</span>
    </div>
    <ul class="list-group">
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.host') }}</strong>
            <span class="pull-right">{{ env('A3L_HOST', '').':'.array_get($a3lserver, 'info.GamePort') }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.map') }}</strong>
            <span class="pull-right">{{ ucwords(array_get($a3lserver, 'info.Map')) }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.next_restart') }}</strong>
            <span class="pull-right">
                in
                @if(array_get($a3lserver, 'restart')->diffInMinutes() <= 90)
                    {{ array_get($a3lserver, 'restart')->diffInMinutes() }}m
                @else
                    {{ number_format(array_get($a3lserver, 'restart')->diffInMinutes() / 60, 2, config('a3lwebinterface.formatter.decimal_seperator'), '') }}h
                @endif
                /
                {{ array_get($a3lserver, 'restart')->format('H:i') }} {{ trans('messages.clock') }}
            </span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.players') }}</strong>
            <span class="pull-right">{{ array_get($a3lserver, 'info.Players').' / '.array_get($a3lserver, 'info.MaxPlayers') }}</span>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" style="width: {{ array_get($a3lserver, 'info.Players') / (array_get($a3lserver, 'info.MaxPlayers') / 100)}}%;"></div>
            </div>
            @if(array_get($a3lserver, 'playersOnline', collect([]))->count())
                <ul class="list-inline">
                    @foreach(array_get($a3lserver, 'playersOnline', []) as $player)
                        <li><p><span class="label label-primary">{{ $player['Name'] }}</span></p></li>
                    @endforeach
                </ul>
            @endif
        </li>
    </ul>
</div>
@endif
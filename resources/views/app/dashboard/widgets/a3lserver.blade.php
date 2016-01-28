@if($a3lserver['online'] && $a3lserver['info'])
<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ array_get($a3lserver, 'info.HostName') }}</span>
    </div>
    <ul class="list-group">
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.host') }}</strong>
            <span class="pull-right">{{ env('A3L_HOST', '').'::'.array_get($a3lserver, 'info.GamePort') }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.map') }}</strong>
            <span class="pull-right">{{ ucwords(array_get($a3lserver, 'info.Map')) }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.players') }}</strong>
            <span class="pull-right">{{ array_get($a3lserver, 'info.Players').' / '.array_get($a3lserver, 'info.MaxPlayers') }}</span>
            @if(array_get($a3lserver, 'playersOnline', collect([]))->count())
                <ul class="list-inline">
                    @foreach(array_get($a3lserver, 'playersOnline', []) as $player)
                        <li><p><span class="label label-success">{{ $player['Name'] }}</span></p></li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.next_restart') }}</strong>
            <span class="pull-right">{{ array_get($a3lserver, 'restart')->format('H:i') }} {{ trans('messages.clock') }}</span>
        </li>
    </ul>
</div>
@endif
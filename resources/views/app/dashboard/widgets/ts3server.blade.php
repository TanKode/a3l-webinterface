@if($ts3server['server']->status == 'online')
    <div class="panel panel-alt4">
        <div class="panel-heading">
            <div class="tools"></div>
            <span class="title">TS3: {{ $ts3server['server']->name }}</span>
        </div>
        <ul class="list-group">
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.host') }}</strong>
                <span class="pull-right">
                    <a href="ts3server://{{ $ts3server['server']->host }}?port={{ $ts3server['server']->port }}">{{ $ts3server['server']->host.':'.$ts3server['server']->port }}</a>
                </span>
            </li>
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.clients') }}</strong>
                <span class="pull-right">{{ $ts3server['clients']->count() . ' / ' . $ts3server['server']->max_clients }}</span>
                <div class="progress">
                    <div class="progress-bar progress-bar-primary" style="width: {{ $ts3server['clients']->count() / ($ts3server['server']->max_clients / 100)}}%;"></div>
                </div>
                @if($ts3server['clients']->count())
                    <ul class="list-inline">
                        @foreach($ts3server['clients'] as $client)
                            <li><p><span class="label label-primary">{{ $client->nickname }}</span></p></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        </ul>
    </div>
@endif
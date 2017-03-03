<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ trans('messages.player_stats') }}</span>
    </div>
    <ul class="list-group">
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.name') }}</strong>
            <span class="pull-right">{{ \Auth::user()->player->name }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.player_id') }}</strong>
            <span class="pull-right">{{ \Auth::user()->player->pid }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.money') }}</strong>
            <span class="pull-right">{{ \Formatter::money(\Auth::user()->player->total_money) }}</span>
        </li>
        @if(\Auth::user()->player->coplevel)
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.cop') }}</strong>
                <span class="pull-right">{{ trans('messages.coplevel.'.\Auth::user()->player->coplevel) }}</span>
            </li>
        @endif
        @if(\Auth::user()->player->mediclevel)
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.medic') }}</strong>
                <span class="pull-right">{{ trans('messages.mediclevel.'.\Auth::user()->player->mediclevel) }}</span>
            </li>
        @endif
    </ul>
    <a href="{{ url('app/user/edit/'.\Auth::id()) }}" class="btn btn-primary btn-block">{{ trans('messages.profile') }}</a>
</div>
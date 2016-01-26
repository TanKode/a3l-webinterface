<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ trans('messages.player_stats') }}</span>
    </div>
    <ul class="list-group">
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.name') }}</strong>
            <span class="pull-right">{{ \Auth::User()->player->name }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.player_id') }}</strong>
            <span class="pull-right">{{ \Auth::User()->player->playerid }}</span>
        </li>
        <li class="list-group-item">
            <strong class="list-group-item-heading">{{ trans('messages.money') }}</strong>
            <span class="pull-right">{{ \Formatter::money(\Auth::User()->player->total_money) }}</span>
        </li>
        @if(\Auth::User()->player->coplevel)
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.cop') }}</strong>
                <span class="pull-right">{{ trans('messages.coplevel.'.\Auth::User()->player->coplevel) }}</span>
            </li>
        @endif
        @if(\Auth::User()->player->mediclevel)
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.medic') }}</strong>
                <span class="pull-right">{{ trans('messages.mediclevel.'.\Auth::User()->player->mediclevel) }}</span>
            </li>
        @endif
        @if(\Auth::User()->player->ataclevel)
            <li class="list-group-item">
                <strong class="list-group-item-heading">{{ trans('messages.atac') }}</strong>
                <span class="pull-right">{{ trans('messages.ataclevel.'.\Auth::User()->player->ataclevel) }}</span>
            </li>
        @endif
    </ul>
</div>
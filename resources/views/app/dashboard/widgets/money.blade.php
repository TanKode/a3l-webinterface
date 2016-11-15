<div class="widget widget-tile">
    <div class="data-info">
        <div class="value">{{ \Formatter::money(\App\Player::sum(\DB::raw('cash + bankacc'))) }}</div>
        <div class="desc">{{ trans('messages.money') }}</div>
    </div>
    <div class="icon"><i class="icon wh-money-cash"></i></div>
</div>
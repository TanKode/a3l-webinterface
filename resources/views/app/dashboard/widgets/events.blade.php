<div class="widget widget-tile">
    <div class="data-info">
        <div class="value">{{ \App\Event::today()->count() }}</div>
        <div class="desc">{{ trans('messages.events_today') }}</div>
    </div>
    <div class="icon"><i class="icon wh-calendarthree"></i></div>
</div>
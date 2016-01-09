<div class="widget widget-tile">
    <div class="data-info">
        <div class="value">{{ \App\House::owned()->count() }}</div>
        <div class="desc">{{ trans('menu.houses') }}</div>
    </div>
    <div class="icon"><i class="icon wh-house"></i></div>
</div>
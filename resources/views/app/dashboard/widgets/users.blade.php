<div class="widget widget-tile">
    <div class="data-info">
        <div class="value">{{ \App\User::confirmed()->count() }}</div>
        <div class="desc">{{ trans('menu.users') }}</div>
    </div>
    <div class="icon"><i class="icon wh-user"></i></div>
</div>
<div class="am-left-sidebar">
    <div class="content">
        <div class="am-logo"></div>
        <ul class="sidebar-elements">
            <li class="@if(Request::is('app/dashboard')) active @endif">
                <a href="{{ url('app/dashboard') }}" class="text-center">
                    <i class="icon wh-speed"></i>
                    <span>{{ trans('menu.dashboard') }}</span>
                </a>
            </li>
            @can('view', App\User::class)
            <li class="@if(Request::is('app/user*')) active @endif">
                <a href="{{ url('app/user') }}" class="text-center">
                    <i class="icon wh-user"></i>
                    <span>{{ trans('menu.users') }}</span>
                </a>
            </li>
            @endcan
            @can('view', App\Player::class)
            <li class="@if(Request::is('app/player*')) active @endif">
                <a href="{{ url('app/player') }}" class="text-center">
                    <i class="icon wh-boardgame"></i>
                    <span>{{ trans('menu.players') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>
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
            <li class="@if(Request::is('app/calendar*')) active @endif">
                <a href="{{ url('app/calendar') }}" class="text-center">
                    @if(\App\Event::today()->count())
                        <span class="badge badge-primary white">{{ \App\Event::today()->count() }}</span>
                    @endif
                    <i class="icon wh-calendarthree"></i>
                    <span>{{ trans('menu.calendar') }}</span>
                </a>
            </li>
            <li class="@if(Request::is('app/chat*')) active @endif">
                <a href="{{ url('app/chat') }}" class="text-center">
                    @if(\Auth::User()->newMessagesCount())
                        <span class="badge badge-primary white">{{ \Auth::User()->newMessagesCount() }}</span>
                    @endif
                    <i class="icon wh-chat"></i>
                    <span>{{ trans('menu.chat') }}</span>
                </a>
            </li>
            @if(\Auth::User()->hasPlayer())
            <li class="@if(Request::is('app/message*')) active @endif">
                <a href="{{ url('app/message') }}" class="text-center">
                    <i class="icon wh-iphone"></i>
                    <span>{{ trans('menu.messages') }}</span>
                </a>
            </li>
            @endif
            <li class="@if(Request::is('app/forum*')) active @endif">
                <a href="{{ url('app/forum') }}" class="text-center">
                    <i class="icon wh-forumsalt"></i>
                    <span>{{ trans('menu.forum') }}</span>
                </a>
            </li>

            @can('view', App\Player::class)
            <li class="@if(Request::is('app/player*')) active @endif">
                <a href="{{ url('app/player') }}" class="text-center">
                    <span class="badge">{{ \App\Player::count() }}</span>
                    <i class="icon wh-boardgame"></i>
                    <span>{{ trans('menu.players') }}</span>
                </a>
            </li>
            @endcan
            @can('view', App\Vehicle::class)
            <li class="@if(Request::is('app/vehicle*')) active @endif">
                <a href="{{ url('app/vehicle') }}" class="text-center">
                    <span class="badge">{{ \App\Vehicle::alive()->count() }}</span>
                    <i class="icon wh-automobile-car"></i>
                    <span>{{ trans('menu.vehicles') }}</span>
                </a>
            </li>
            @endcan

            @can('view', App\User::class)
            <li class="@if(Request::is('app/user*')) active @endif">
                <a href="{{ url('app/user') }}" class="text-center">
                    <span class="badge">{{ \App\User::count() }}</span>
                    <i class="icon wh-user"></i>
                    <span>{{ trans('menu.users') }}</span>
                </a>
            </li>
            @endcan
            @can('view', App\Role::class)
            <li class="@if(Request::is('app/role*')) active @endif">
                <a href="{{ url('app/role') }}" class="text-center">
                    <i class="icon wh-firewall"></i>
                    <span>{{ trans('menu.roles') }}</span>
                </a>
            </li>
            @endcan
            @can('view-backups')
            <li class="@if(Request::is('app/backup*')) active @endif">
                <a href="{{ url('app/backup') }}" class="text-center">
                    <i class="icon wh-backup-vault"></i>
                    <span>{{ trans('menu.backups') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>
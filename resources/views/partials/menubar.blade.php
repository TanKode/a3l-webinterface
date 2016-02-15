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

            @if(\Auth::User()->hasPlayer())
                <li class="parent">
                    <a href="#" class="text-center">
                        <i class="icon wh-gameboy"></i>
                        <span>{{ trans('menu.ingame') }}</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="title">{{ trans('menu.ingame') }}</li>
                        <li class="nav-items">
                            <div class="am-scroller nano has-scrollbar"><div class="content nano-content">
                                    <ul>
                                        <li class="@if(Request::is('app/message*')) active @endif">
                                            <a href="{{ url('app/message') }}" class="white">
                                                <i class="icon wh-iphone"></i>
                                                <span>{{ trans('menu.messages') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if(Request::is('app/lotto*')) active @endif">
                                            <a href="{{ url('app/lotto') }}" class="white">
                                                <i class="icon wh-piggybank"></i>
                                                <span>{{ trans('menu.lotto') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if(Request::is('app/fine/calculator')) active @endif">
                                            <a href="{{ url('app/fine/calculator') }}" class="white">
                                                <i class="icon wh-calculator"></i>
                                                <span>{{ trans('menu.fine_calculator') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('page/busgeld') }}" class="white">
                                                <i class="icon wh-police"></i>
                                                <span>{{ trans('menu.fine') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('page/regeln') }}" class="white">
                                                <i class="icon wh-law"></i>
                                                <span>{{ trans('menu.rules') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="parent">
                <a href="#" class="text-center">
                    <i class="icon wh-community"></i>
                    <span>{{ trans('menu.community') }}</span>
                </a>
                <ul class="sub-menu">
                    <li class="title">{{ trans('menu.community') }}</li>
                    <li class="nav-items">
                        <div class="am-scroller nano has-scrollbar"><div class="content nano-content">
                                <ul>
                                    <li class="@if(Request::is('app/calendar*')) active @endif">
                                        <a href="{{ url('app/calendar') }}" class="white">
                                            @if(\App\Event::today()->count())
                                                <span class="badge badge-primary white">{{ \App\Event::today()->count() }}</span>
                                            @endif
                                            <i class="icon wh-calendarthree"></i>
                                            <span>{{ trans('menu.calendar') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if(Request::is('app/chat*')) active @endif">
                                        <a href="{{ url('app/chat') }}" class="white">
                                            @if(\Auth::User()->newMessagesCount())
                                                <span class="badge badge-primary white">{{ \Auth::User()->newMessagesCount() }}</span>
                                            @endif
                                            <i class="icon wh-chat"></i>
                                            <span>{{ trans('menu.chat') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if(Request::is('app/forum*')) active @endif">
                                        <a href="{{ url('app/forum') }}" class="white">
                                            <i class="icon wh-forumsalt"></i>
                                            <span>{{ trans('menu.forum') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>

            @can('access-support')
            <li class="parent">
                <a href="#" class="text-center">
                    <i class="icon wh-supportalt"></i>
                    <span>{{ trans('menu.support') }}</span>
                </a>
                <ul class="sub-menu">
                    <li class="title">{{ trans('menu.support') }}</li>
                    <li class="nav-items">
                        <div class="am-scroller nano has-scrollbar"><div class="content nano-content">
                                <ul>
                                    @can('view-list', App\Player::class)
                                    <li class="@if(Request::is('app/player*')) active @endif">
                                        <a href="{{ url('app/player') }}" class="white">
                                            <span class="badge badge-primary white">{{ \App\Player::count() }}</span>
                                            <i class="icon wh-boardgame"></i>
                                            <span>{{ trans('menu.players') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('view', App\Vehicle::class)
                                    <li class="@if(Request::is('app/vehicle*')) active @endif">
                                        <a href="{{ url('app/vehicle') }}" class="white">
                                            <span class="badge badge-primary white">{{ \App\Vehicle::alive()->count() }}</span>
                                            <i class="icon wh-automobile-car"></i>
                                            <span>{{ trans('menu.vehicles') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @endcan

            @can('access-admin')
            <li class="parent">
                <a href="#" class="text-center">
                    <i class="icon wh-lock"></i>
                    <span>{{ trans('menu.admin') }}</span>
                </a>
                <ul class="sub-menu">
                    <li class="title">{{ trans('menu.admin') }}</li>
                    <li class="nav-items">
                        <div class="am-scroller nano has-scrollbar"><div class="content nano-content">
                                <ul>
                                    @can('view', App\User::class)
                                    <li class="@if(Request::is('app/user*')) active @endif">
                                        <a href="{{ url('app/user') }}" class="white">
                                            <span class="badge badge-primary white">{{ \App\User::count() }}</span>
                                            <i class="icon wh-user"></i>
                                            <span>{{ trans('menu.users') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('view', App\Role::class)
                                    <li class="@if(Request::is('app/role*')) active @endif">
                                        <a href="{{ url('app/role') }}" class="white">
                                            <i class="icon wh-firewall"></i>
                                            <span>{{ trans('menu.roles') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('view-backups')
                                    <li class="@if(Request::is('app/backup*')) active @endif">
                                        <a href="{{ url('app/backup') }}" class="white">
                                            <i class="icon wh-backup-vault"></i>
                                            <span>{{ trans('menu.backups') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</div>
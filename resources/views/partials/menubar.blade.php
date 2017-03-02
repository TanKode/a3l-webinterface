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

            <li class="@if(Request::is('app/wanted')) active @endif">
                <a href="{{ url('app/wanted') }}" class="text-center">
                    <i class="icon wh-handcuffs"></i>
                    <span>{{ trans('menu.wanted_list') }}</span>
                </a>
            </li>
            <li class="@if(Request::is('page/busgeld')) active @endif">
                <a href="{{ url('page/busgeld') }}" class="text-center">
                    <i class="icon wh-police"></i>
                    <span>{{ trans('menu.fine') }}</span>
                </a>
            </li>
            <li class="@if(Request::is('page/regeln')) active @endif">
                <a href="{{ url('page/regeln') }}" class="text-center">
                    <i class="icon wh-law"></i>
                    <span>{{ trans('menu.rules') }}</span>
                </a>
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
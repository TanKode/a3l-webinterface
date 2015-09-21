<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu">
                    <li class="site-menu-item @if(Request::is('app/dashboard')) active @endif">
                        <a href="{{ url('app/dashboard') }}">
                            <i class="site-menu-icon fa-dashboard"></i>
                            <span class="site-menu-title">Dashboard</span>
                        </a>
                    </li>

                    @if(\Auth::User()->canAccess('administration'))
                    <li class="site-menu-category">Adminbereich</li>
                    @if(\Auth::User()->canAccess('access_management'))
                    <li class="site-menu-item has-sub @if(Request::is('app/user*') || Request::is('app/role*') || Request::is('app/ability*')) active open @endif">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fa-user"></i>
                            <span class="site-menu-title">Zugriffsrechte</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            @can('manage', \App\User::class)
                            <li class="site-menu-item @if(Request::is('app/user*')) active @endif">
                                <a href="{{ url('app/user') }}">
                                    <i class="site-menu-icon fa-list"></i>
                                    <span class="site-menu-title">Benutzer</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage', \Silber\Bouncer\Database\Role::class)
                            <li class="site-menu-item @if(Request::is('app/role*')) active @endif">
                                <a href="{{ url('app/role') }}">
                                    <i class="site-menu-icon fa-group"></i>
                                    <span class="site-menu-title">Rollen</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage', \Silber\Bouncer\Database\Ability::class)
                            <li class="site-menu-item @if(Request::is('app/ability*')) active @endif">
                                <a href="{{ url('app/ability') }}">
                                    <i class="site-menu-icon fa-key"></i>
                                    <span class="site-menu-title">Berechtigungen</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    <li class="site-menu-item @if(Request::is('app/setting*')) active @endif">
                        <a href="{{ url('app/setting') }}">
                            <i class="site-menu-icon fa-cogs"></i>
                            <span class="site-menu-title">Einstellungen</span>
                        </a>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
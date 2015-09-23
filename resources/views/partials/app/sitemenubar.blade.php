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

                    @if(\Auth::User()->canAccess('content'))
                    <li class="site-menu-category">Content</li>
                    @if(\Auth::User()->canAccess('blog'))
                    <li class="site-menu-item has-sub @if(Request::is('app/post*')) active open @endif">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fa-file-text-o"></i>
                            <span class="site-menu-title">Blog</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item @if(Request::is('app/post*')) active @endif">
                                <a href="{{ url('app/user') }}">
                                    <i class="site-menu-icon fa-paragraph"></i>
                                    <span class="site-menu-title">Beiträge</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="site-menu-item @if(Request::is('app/page*')) active @endif">
                        <a href="{{ url('app/page') }}">
                            <i class="site-menu-icon fa-file-text"></i>
                            <span class="site-menu-title">Seite</span>
                        </a>
                    </li>
                    @endif

                    @if(\Auth::User()->canAccess('administration'))
                    <li class="site-menu-category">Adminbereich</li>
                    @can('manage', \App\Donation::class)
                    <li class="site-menu-item @if(Request::is('app/donation*')) active @endif">
                        <a href="{{ url('app/donation') }}">
                            <i class="site-menu-icon text-success fa-money"></i>
                            <span class="site-menu-title">Spenden</span>
                        </a>
                    </li>
                    @endcan
                    @if(\Auth::User()->canAccess('access_management'))
                    <li class="site-menu-item has-sub @if(Request::is('app/user*') || Request::is('app/role*') || Request::is('app/ability*')) active open @endif">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fa-lock"></i>
                            <span class="site-menu-title">Zugriffsrechte</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            @can('manage', \App\User::class)
                            <li class="site-menu-item @if(Request::is('app/user*')) active @endif">
                                <a href="{{ url('app/user') }}">
                                    <i class="site-menu-icon text-warning fa-user"></i>
                                    <span class="site-menu-title">Benutzer</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage', \Silber\Bouncer\Database\Role::class)
                            <li class="site-menu-item @if(Request::is('app/role*')) active @endif">
                                <a href="{{ url('app/role') }}">
                                    <i class="site-menu-icon text-warning fa-group"></i>
                                    <span class="site-menu-title">Rollen</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage', \Silber\Bouncer\Database\Ability::class)
                            <li class="site-menu-item @if(Request::is('app/ability*')) active @endif">
                                <a href="{{ url('app/ability') }}">
                                    <i class="site-menu-icon text-success fa-key"></i>
                                    <span class="site-menu-title">Berechtigungen</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @can('manage', \App\Server::class)
                    <li class="site-menu-item @if(Request::is('app/server*')) active @endif">
                        <a href="{{ url('app/server') }}">
                            <i class="site-menu-icon fa-server"></i>
                            <span class="site-menu-title">Server</span>
                        </a>
                    </li>
                    @endcan
                    @can('manage', \App\Setting::class)
                    <li class="site-menu-item @if(Request::is('app/setting*')) active @endif">
                        <a href="{{ url('app/setting') }}">
                            <i class="site-menu-icon text-success fa-cogs"></i>
                            <span class="site-menu-title">Einstellungen</span>
                        </a>
                    </li>
                    @endcan
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="site-menubar-footer">
        <a href="https://bambusfarm.slack.com" target="_blank" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Slack">
            <span class="icon fa-slack"></span>
        </a>
        <a href="{{ url('app/profile/edit/'.\Auth::User()->id) }}" data-placement="top" data-toggle="tooltip" data-original-title="Profil">
            <span class="icon fa-user"></span>
        </a>
        <a href="{{ url('auth/logout') }}" data-placement="top" data-toggle="tooltip" data-original-title="Abmelden">
            <span class="icon fa-power-off"></span>
        </a>
    </div>
</div>
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
                    <li class="site-menu-item @if(Request::is('app/forum*')) active @endif">
                        <a href="{{ url('app/forum') }}">
                            <i class="site-menu-icon fa-comments-o"></i>
                            <span class="site-menu-title">Forum</span>
                        </a>
                    </li>
                    <li class="site-menu-item @if(Request::is('app/issue*')) active @endif">
                        <a href="{{ url('app/issue') }}">
                            <i class="site-menu-icon fa-bug"></i>
                            <span class="site-menu-title">Tickets</span>
                        </a>
                    </li>

                    @if(\Auth::User()->canAccess('a3l'))
                    <li class="site-menu-category">Altis Life</li>
                    @if(\Auth::User()->can('manage', \App\A3L\Player::class))
                        <li class="site-menu-item @if(Request::is('app/a3l/player*')) active @endif">
                            <a href="{{ url('app/a3l/player') }}">
                                <i class="site-menu-icon text-warning fa-user"></i>
                                <span class="site-menu-title">Spieler</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3L\Player::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\A3L\Vehicle::class))
                        <li class="site-menu-item @if(Request::is('app/a3l/vehicle*')) active @endif">
                            <a href="{{ url('app/a3l/vehicle') }}">
                                <i class="site-menu-icon text-warning fa-car"></i>
                                <span class="site-menu-title">Fahrzeuge</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3L\Vehicle::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @endif


                    @if(\Auth::User()->canAccess('a3e'))
                    <li class="site-menu-category">Exile</li>
                    @if(\Auth::User()->can('manage', \App\A3E\Account::class))
                        <li class="site-menu-item @if(Request::is('app/a3e/account*')) active @endif">
                            <a href="{{ url('app/a3e/account') }}">
                                <i class="site-menu-icon text-danger fa-user"></i>
                                <span class="site-menu-title">Accounts</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3E\Account::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\A3E\Player::class))
                        <li class="site-menu-item @if(Request::is('app/a3e/player*')) active @endif">
                            <a href="{{ url('app/a3e/player') }}">
                                <i class="site-menu-icon text-danger fa-user"></i>
                                <span class="site-menu-title">Spieler</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3E\Player::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\A3E\Vehicle::class))
                        <li class="site-menu-item @if(Request::is('app/a3e/vehicle*')) active @endif">
                            <a href="{{ url('app/a3e/vehicle') }}">
                                <i class="site-menu-icon text-danger fa-car"></i>
                                <span class="site-menu-title">Fahrzeuge</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3E\Vehicle::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\A3E\Territory::class))
                        <li class="site-menu-item @if(Request::is('app/a3e/territory*')) active @endif">
                            <a href="{{ url('app/a3e/territory') }}">
                                <i class="site-menu-icon text-danger fa-map"></i>
                                <span class="site-menu-title">Gebiete</span>
                                <div class="site-menu-badge">
                                    <span class="badge badge-dark">{{ \App\A3E\Territory::count() }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    @endif

                    @if(\Auth::User()->canAccess('administration'))
                    <li class="site-menu-category">Adminbereich</li>
                    @if(\Auth::User()->can('manage', \App\Donation::class))
                    <li class="site-menu-item @if(Request::is('app/donation*')) active @endif">
                        <a href="{{ url('app/donation') }}">
                            <i class="site-menu-icon fa-money"></i>
                            <span class="site-menu-title">Spenden</span>
                        </a>
                    </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\Accounting::class))
                        <li class="site-menu-item @if(Request::is('app/accounting*')) active @endif">
                            <a href="{{ url('app/accounting') }}">
                                <i class="site-menu-icon fa-book"></i>
                                <span class="site-menu-title">Buchhaltung</span>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->canAccess('access_management'))
                    <li class="site-menu-item has-sub @if(Request::is('app/user*') || Request::is('app/role*') || Request::is('app/ability*')) active open @endif">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fa-lock"></i>
                            <span class="site-menu-title">Zugriffsrechte</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            @if(\Auth::User()->can('manage', \App\User::class))
                            <li class="site-menu-item @if(Request::is('app/user*')) active @endif">
                                <a href="{{ url('app/user') }}">
                                    <i class="site-menu-icon fa-user"></i>
                                    <span class="site-menu-title">Benutzer</span>
                                    <div class="site-menu-badge">
                                        <span class="badge badge-dark">{{ \App\User::count() }}</span>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if(\Auth::User()->can('manage', \Silber\Bouncer\Database\Role::class))
                            <li class="site-menu-item @if(Request::is('app/role*')) active @endif">
                                <a href="{{ url('app/role') }}">
                                    <i class="site-menu-icon fa-group"></i>
                                    <span class="site-menu-title">Rollen</span>
                                </a>
                            </li>
                            @endif
                            @if(\Auth::User()->can('manage', \Silber\Bouncer\Database\Ability::class))
                            <li class="site-menu-item @if(Request::is('app/ability*')) active @endif">
                                <a href="{{ url('app/ability') }}">
                                    <i class="site-menu-icon fa-key"></i>
                                    <span class="site-menu-title">Berechtigungen</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if(\Auth::User()->can('manage-backup'))
                        <li class="site-menu-item @if(Request::is('app/backup*')) active @endif">
                            <a href="{{ url('app/backup') }}">
                                <i class="site-menu-icon fa-cloud-download"></i>
                                <span class="site-menu-title">Backups</span>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\Log::class))
                        <li class="site-menu-item @if(Request::is('app/log*')) active @endif">
                            <a href="{{ url('app/log') }}">
                                <i class="site-menu-icon fa-list"></i>
                                <span class="site-menu-title">Log</span>
                            </a>
                        </li>
                    @endif
                    @if(\Auth::User()->can('manage', \App\Setting::class))
                    <li class="site-menu-item @if(Request::is('app/setting*')) active @endif">
                        <a href="{{ url('app/setting') }}">
                            <i class="site-menu-icon fa-cogs"></i>
                            <span class="site-menu-title">Einstellungen</span>
                        </a>
                    </li>
                    @endif
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="site-menubar-footer">
        <a href="https://bambusfarm.slack.com" target="_blank" data-placement="top" data-toggle="tooltip" data-original-title="Slack">
            <span class="icon fa-slack"></span>
        </a>
        <a href="{{ url('app/profile/edit/'.\Auth::User()->id) }}" data-placement="top" data-toggle="tooltip" data-original-title="Profil">
            <span class="icon fa-user"></span>
        </a>
        <a href="{{ url('auth/logout') }}" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Abmelden">
            <span class="icon fa-power-off"></span>
        </a>
    </div>
</div>
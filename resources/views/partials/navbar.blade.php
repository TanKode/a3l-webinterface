<nav class="navbar navbar-default navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="page-title">
                <span>{{ trans('messages.title') }}</span>
            </div>
            <a href="#" class="am-toggle-left-sidebar navbar-toggle collapsed">
                <span class="icon-bar"><span></span><span></span><span></span></span>
            </a>
            <a href="{{ url('/') }}" class="navbar-brand text-center">
                <i class="icon wh-pokemon icon-2x"></i>
            </a>
        </div>
        <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <i class="icon wh-chevron-down"></i>
        </a>
        <div id="am-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right am-user-nav">
                <li>
                    <img src="{{ \Auth::User()->avatar(50) }}" class="img-circle padding-15" data-toggle="tooltip" data-placement="bottom" title="{{ \Auth::User()->name }}" />
                </li>
                <li>
                    <a href="{{ url('auth/logout') }}" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.signout') }}">
                        <i class="icon wh-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
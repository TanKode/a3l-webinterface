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
                <i class="icon wh-warmedal icon-2x"></i>
            </a>
        </div>
        <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <i class="icon wh-chevron-down"></i>
        </a>
        <div id="am-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right am-user-nav">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <img src="{{ \Auth::user()->avatar(50) }}" />
                        <span class="user-name">{{ \Auth::user()->name }}</span>
                        <i class="angle-down wh-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('app/user/edit/'.\Auth::id()) }}"> <span class="icon wh-user"></span>{{ trans('messages.profile') }}</a></li>
                        <li><a href="{{ url('auth/logout') }}"> <i class="icon wh-off"></i>{{ trans('messages.signout') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
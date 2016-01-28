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
            <ul class="nav navbar-nav am-nav-right">
                @if(\App\Event::today()->count())
                    <li>
                        <a href="{{ url('app/calendar') }}" data-toggle="tooltip" data-placement="bottom" title="{{ \App\Event::today()->first()->title }}">
                            <i class="icon wh-calendarthree icon-2x"></i>
                        </a>
                    </li>
                @endif
                @if(\Auth::User()->newMessagesCount())
                    <li>
                        <a href="{{ url('app/chat') }}" data-toggle="tooltip" data-placement="bottom" title="{{ \Auth::User()->newMessagesCount() }} {{ trans('messages.unread_messages') }}">
                            <i class="icon wh-chat icon-2x"></i>
                        </a>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right am-user-nav">
                <li>
                    <img src="{{ \Auth::User()->avatar(50) }}" class="img-circle padding-15" data-toggle="tooltip" data-placement="bottom" title="{{ \Auth::User()->name }}" />
                </li>
                <li>
                    <a href="https://gummibeer.freshdesk.com/support/tickets/new" target="_blank" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.support') }}">
                        <i class="icon wh-supportalt icon-2x"></i>
                    </a>
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
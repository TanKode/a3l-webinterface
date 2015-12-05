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
            <li class="@if(Request::is('app/user*')) active @endif">
                <a href="{{ url('app/user') }}" class="text-center">
                    <i class="icon wh-user"></i>
                    <span>{{ trans('menu.users') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
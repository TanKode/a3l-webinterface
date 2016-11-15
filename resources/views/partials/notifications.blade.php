<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="icon wh-bell icon-2x"></i>
        @if(\Auth::User()->countNotificationsNotRead())
            <span class="indicator"></span>
        @endif
    </a>
    <ul class="dropdown-menu am-notifications">
        <li>
            <div class="title">Notifications<span class="badge">{{ \Auth::User()->countNotificationsNotRead() }}</span></div>
            <div class="list">
                <div class="am-scroller nano">
                    <div class="content nano-content">
                        <ul>
                            @foreach(\Auth::User()->getNotifications() as $notification)
                                <li class="@if(!$notification->read) active @endif">
                                    <a href="{{ url('app/user/read-notify/'.$notification->getKey()) }}">
                                        <div class="logo">
                                            <i class="icon wh-pin"></i>
                                        </div>
                                        <div class="user-content">
                                            @if(!$notification->read)
                                                <span class="circle"></span>
                                            @endif
                                            <span class="text-content">{{ trans($notification->text, $notification->extra->toArray()) }}</span>
                                            <span class="date">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer"><a href="{{ url('app/user/read-notify/0') }}">{{ trans('messages.read_all_notify') }}</a></div>
        </li>
    </ul>
</li>
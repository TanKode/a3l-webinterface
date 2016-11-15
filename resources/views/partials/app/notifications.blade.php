<li class="dropdown">
    <a data-toggle="dropdown" href="javascript:void(0)">
        <i class="icon fa-bell"></i>
        @if(\Auth::User()->countNotificationsNotRead() > 0)
            <span class="badge badge-danger up">{{ \Auth::User()->countNotificationsNotRead() }}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
        <li class="dropdown-menu-header">
            <h5 class="text-uppercase">Benachrichtigungen</h5>
            <a href="{{ url('app/notification/readall') }}" class="label label-default pull-right">
                <i class="icon fa-envelope-o"></i>
                gelesen
            </a>
        </li>

        <li class="list-group scrollable is-enabled scrollable-vertical">
            <div data-role="container" class="scrollable-container">
                <div data-role="content" class="scrollable-content list-group">
                    @foreach(\Auth::User()->getNotifications() as $notification)
                    <a class="list-group-item @if($notification->read) disabled @endif" href="@if($notification->read)javascript:void(0)@else{{ url('app/notification/read/'.$notification->id) }}@endif">
                        <div class="media">
                            <div class="media-left padding-right-10">
                                @if($notification->read)
                                    <i class="icon fa-envelope-o bg-dark white icon-circle"></i>
                                @else
                                    <i class="icon fa-envelope bg-danger white icon-circle"></i>
                                @endif
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">{!! \MarkExtra::defaultTransform($notification->notify_body) !!}</h6>
                                <time class="media-meta" datetime="{{ $notification->created_at->toW3cString() }}">{{ $notification->created_at->diffForHumans() }}</time>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide" draggable="false"><div class="scrollable-bar-handle"></div></div>
        </li>
    </ul>
</li>
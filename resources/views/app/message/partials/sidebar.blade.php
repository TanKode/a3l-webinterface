<aside class="page-aside">
    <div class="am-scroller nano has-scrollbar">
        <div class="nano-content">
            <div class="content">
                <div class="aside-header clearfix margin-0">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".aside-nav"><span class="icon wh-chevron-down"></span></button>
                    <h2 class="pull-left margin-0">{{ trans('menu.chat') }}</h2>
                </div>
            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    @foreach($participants as $player)
                        <li>
                            <a href="{{ url('app/message/' . $player->getKey()) }}">
                                <i class="icon wh-chat"></i>
                                {{ $player->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</aside>
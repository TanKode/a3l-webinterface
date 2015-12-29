<aside class="page-aside">
    <div class="am-scroller nano has-scrollbar">
        <div class="nano-content">
            <div class="content">
                <div class="aside-header clearfix">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".aside-nav"><span class="icon wh-chevron-down"></span></button>
                    <h2 class="pull-left">{{ trans('menu.chat') }}</h2>
                </div>
            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    @foreach($threads as $thread)
                        <li>
                            <a href="{{ url('app/chat/' . $thread->getKey()) }}">
                                <i class="icon wh-bookmark"></i>
                                {{ \App\User::whereIn('id', collect($thread->participantsUserIds())->keyBy(function($id){return $id;})->forget(\Auth::id())->toArray())->lists('name')->implode(', ') }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="aside-compose">
                    <a href="{{ url('app/chat/create') }}" class="btn btn-primary btn-block">{{ trans('messages.new_chat') }}</a>
                </div>
            </div>
        </div>
    </div>
</aside>
@extends('app')

@section('title', 'Dashboard')

@section('content')
    <ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2" data-plugin="masonry">
        @if(\Auth::User()->can('manage', \App\Accounting::class))
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 @if($accounting_sum < 0) bg-red-600 @else bg-green-600 @endif clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number white">{{ format_money($accounting_sum) }}</span>
                        </div>
                        <div class="counter-label font-size-16">Kontostand</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-money"></i>
                    </div>
                </div>
            </div>
        </li>
        @endif
        @if(\Auth::User()->can('manage', \App\Donation::class))
            <li class="masonry-item">
                <div class="widget">
                    <div class="widget-content padding-30 bg-primary-600 clearfix">
                        <div class="counter counter-md pull-left text-left counter-inverse">
                            <div class="counter-number-group">
                                <span class="counter-number">{{ $bamboo_coins_sum }}</span>
                                <span class="counter-number-related text-capitalize">Bamboo-Coins</span>
                            </div>
                            <div class="counter-label font-size-16">im Umlauf</div>
                        </div>
                        <div class="pull-right white">
                            <i class="icon icon-3x fa-leaf"></i>
                        </div>
                    </div>
                </div>
            </li>
        @endif
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-red-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $gitlab['issues']['open']->count() }}</span>
                            <span class="counter-number-related text-capitalize">Tickets</span>
                        </div>
                        <div class="counter-label font-size-16">sind noch offen</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-bug"></i>
                    </div>
                    @if($gitlab['issues']['all']->count() > 0)
                    <div class="clearfix"></div>
                    <div class="clearfix white margin-top-10">
                        <div class="pull-left">Tickets</div>
                        <div class="pull-right">{{ $gitlab['issues']['closed']->count() }} / {{ $gitlab['issues']['all']->count() }}</div>
                    </div>
                    <div class="progress progress-xs bg-red-600 margin-0">
                        <div class="progress-bar bg-white" style="width: {{ round(($gitlab['issues']['closed']->count() / $gitlab['issues']['all']->count()) * 100) }}%;"></div>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-purple-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3l['player_count'] }}</span>
                            <span class="counter-number-related text-capitalize">Spieler</span>
                        </div>
                        <div class="counter-label font-size-16">Altis Life</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-user"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-purple-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3l['vehicle_count'] }}</span>
                            <span class="counter-number-related text-capitalize">Fahrzeuge</span>
                        </div>
                        <div class="counter-label font-size-16">Altis Life</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-car"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-purple-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ format_money($a3l['money_sum']) }}</span>
                        </div>
                        <div class="counter-label font-size-16">Altis Life</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-money"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-purple-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3l['karma_sum'] }}</span>
                            <span class="counter-number-related text-capitalize">Karma</span>
                        </div>
                        <div class="counter-label font-size-16">Altis Life</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x @if($a3l['karma_sum'] < 0) fa-frown-o @else fa-smile-o @endif"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-white">
                    <div class="counter counter-md text-left">
                        <div class="counter-label margin-bottom-5 clearfix">
                            <span class="pull-lefft">89.163.139.86:2302</span>
                            <span class="pull-right">
                                @if(is_array($a3l['info']))
                                    <i class="icon fa-circle text-success"></i>
                                @else
                                    <i class="icon fa-circle-o text-danger"></i>
                                @endif
                            </span>
                        </div>
                        <div class="counter-number-group margin-bottom-10">
                            <span class="counter-number">Altis Life</span>
                        </div>
                        @if(is_array($a3l['info']))
                        <div class="margin-bottom-15 clearfix">
                            <span class="pull-left">
                                <i class="icon fa-clock-o"></i>
                                {{ $a3l['restart']->format('H:i') }} Uhr
                            </span>
                            <span class="badge pull-right">
                                {{ $a3l['restart']->diffForHumans() }}
                            </span>
                        </div>
                        <div class="counter-label">
                            <div class="clearfix">
                                <div class="pull-left">Spieler</div>
                                <div class="pull-right">{{ $a3l['info']['Players'] }} / {{ $a3l['info']['MaxPlayers'] }}</div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-purple-600" style="width: {{ round(($a3l['info']['Players'] / $a3l['info']['MaxPlayers']) * 100) }}%;"></div>
                            </div>
                            @if($a3l['info']['Players'] > 0)
                            <ul class="list-inline">
                                @foreach($a3l['playersOnline'] as $player)
                                    <li class="label label-dark bg-purple-600">{{ $player['Name'] }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-white">
                    <div class="counter counter-md text-left">
                        <div class="counter-label margin-bottom-5 clearfix">
                            <span class="pull-lefft">89.163.139.86:2312</span>
                        <span class="pull-right">
                            @if(is_array($a3e['info']))
                                <i class="icon fa-circle text-success"></i>
                            @else
                                <i class="icon fa-circle-o text-danger"></i>
                            @endif
                        </span>
                        </div>
                        <div class="counter-number-group margin-bottom-10">
                            <span class="counter-number">Exile</span>
                        </div>
                        @if(is_array($a3e['info']))
                            <div class="margin-bottom-15 clearfix">
                                <span class="pull-left">
                                    <i class="icon fa-clock-o"></i>
                                    {{ $a3e['restart']->format('H:i') }} Uhr
                                </span>
                                <span class="badge pull-right">
                                    {{ $a3e['restart']->diffForHumans() }}
                                </span>
                            </div>
                            <div class="counter-label">
                                <div class="clearfix">
                                    <div class="pull-left">Spieler</div>
                                    <div class="pull-right">{{ $a3e['info']['Players'] }} / {{ $a3e['info']['MaxPlayers'] }}</div>
                                </div>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-brown-600" style="width: {{ round(($a3e['info']['Players'] / $a3e['info']['MaxPlayers']) * 100) }}%;"></div>
                                </div>
                                @if($a3e['info']['Players'] > 0)
                                    <ul class="list-inline">
                                        @foreach($a3e['playersOnline'] as $player)
                                            <li class="label label-dark bg-purple-600">{{ $player['Name'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['account_count'] }}</span>
                            <span class="counter-number-related text-capitalize">Spieler</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-user"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['territory_count'] }}</span>
                            <span class="counter-number-related text-capitalize">Gebiete</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-flag"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['money_sum'] }}</span>
                            <span class="counter-number-related text-capitalize">Pop Tabs</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-money"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['score_sum'] }}</span>
                            <span class="counter-number-related text-capitalize">Respekt</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-star"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['kills_sum'] }}</span>
                            <span class="counter-number-related text-capitalize">Kills</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-bomb"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="masonry-item">
            <div class="widget">
                <div class="widget-content padding-30 bg-brown-600 clearfix">
                    <div class="counter counter-md pull-left text-left counter-inverse">
                        <div class="counter-number-group">
                            <span class="counter-number">{{ $a3e['deaths_sum'] }}</span>
                            <span class="counter-number-related text-capitalize">Tote</span>
                        </div>
                        <div class="counter-label font-size-16">Exile</div>
                    </div>
                    <div class="pull-right white">
                        <i class="icon icon-3x fa-heartbeat"></i>
                    </div>
                </div>
            </div>
        </li>
    </ul>
@endsection
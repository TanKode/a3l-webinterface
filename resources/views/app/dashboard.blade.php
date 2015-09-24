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
                    <div class="widget-content padding-30 bg-white clearfix">
                        <div class="counter counter-md pull-left text-left">
                            <div class="counter-number-group">
                                <span class="counter-number">{{ $bamboo_coins_sum }}</span>
                                <span class="counter-number-related text-capitalize">Bamboo-Coins</span>
                            </div>
                            <div class="counter-label font-size-16">im Umlauf</div>
                        </div>
                        <div class="pull-right white">
                            <i class="icon icon-circle icon-2x fa-leaf bg-primary-600"></i>
                        </div>
                    </div>
                </div>
            </li>
        @endif
    </ul>
@endsection
@if(!is_null($lotto))
    <div class="widget widget-tile">
        <div class="data-info">
            <div class="value">{{ \Formatter::money($lotto->jackpot) }}</div>
            <div class="desc">
                {{ trans('messages.jackpot') }}
                <br/>
                {{ trans('messages.next_draw', [
                    'date' => $lotto->getNextDrawDate()->format('d.m.Y H:i'),
                ]) }}
            </div>
        </div>
        <div class="icon"><i class="icon wh-piggybank"></i></div>
    </div>
@endif
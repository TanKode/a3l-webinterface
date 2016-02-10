@extends('app')

@section('content')
    <div class="panel">
        <header class="panel-heading">
            <h4 class="panel-title">{{ trans('messages.lotto') }}</h4>
        </header>
        {!! Alert::info([
            trans('messages.next_draw', [
                'date' => $lotto->getNextDrawDate()->format('d.m.Y H:i'),
            ]),
            trans('messages.jackpot') . ': ' . \Formatter::money($lotto->jackpot),
        ]) !!}
        <section class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_1') }}:</strong> {{ $numbers[0] }}
                </div>
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_2') }}:</strong> {{ $numbers[1] }}
                </div>
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_3') }}:</strong> {{ $numbers[2] }}
                </div>
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_4') }}:</strong> {{ $numbers[3] }}
                </div>
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_5') }}:</strong> {{ $numbers[4] }}
                </div>
                <div class="col-md-2">
                    <strong>{{ trans('messages.number_6') }}:</strong> {{ $numbers[5] }}
                </div>
            </div>
        </section>
    </div>
@endsection
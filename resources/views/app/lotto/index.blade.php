@extends('app')

@section('content')
    <div class="panel">
        <header class="panel-heading">
            <h4 class="panel-title">{{ trans('messages.lotto') }}</h4>
        </header>
        {!! Alert::info([
            trans('messages.lotto_bet_info', [
                'bet_cost' => \Formatter::money(config('a3lwebinterface.lotto.cost')),
            ]),
            trans('messages.next_draw', [
                'date' => $lotto->getNextDrawDate()->format('d.m.Y H:i'),
            ]),
            trans('messages.jackpot') . ': ' . \Formatter::money($lotto->jackpot),
        ]) !!}
        <section class="panel-body">
            {!! Form::open([
                'url' => 'app/lotto/bet',
            ]) !!}
                <div class="row">
                    <div class="col-md-2">
                        {!! Form::number('number_1', old('number_1', 1), [
                            'label' => trans('messages.number_1'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_1'),
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::number('number_2', old('number_2', 1), [
                            'label' => trans('messages.number_2'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_2'),
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::number('number_3', old('number_3', 1), [
                            'label' => trans('messages.number_3'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_3'),
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::number('number_4', old('number_4', 1), [
                            'label' => trans('messages.number_4'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_4'),
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::number('number_5', old('number_5', 1), [
                            'label' => trans('messages.number_5'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_5'),
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::number('number_6', old('number_6', 1), [
                            'label' => trans('messages.number_6'),
                            'min' => 1,
                            'max' => 49,
                            'step' => 1,
                            'errors' => $errors->get('number_6'),
                        ]) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::submit(trans('messages.buy', [
                            'price' => \Formatter::money(config('a3lwebinterface.lotto.cost')),
                        ]), [
                            'class' => 'btn-warning pull-right',
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection
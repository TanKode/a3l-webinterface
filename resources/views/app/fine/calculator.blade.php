@extends('app')

@section('content')
    {!! Form::open([
        'url' => 'app/fine/calculator/',
    ]) !!}
    <div class="panel panel-success">
        <div class="panel-heading">
            <h4 class="panel-title">{{ trans('menu.fine_calculator') }}</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12">
                    {!! Form::multiselect('fines[]', $fines, null, [
                        'label' => trans('messages.fines'),
                        'errors' => $errors->get('fines'),
                    ]) !!}
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="btn-group pull-right">
                        {!! Form::submit(trans('messages.calculate'), [
                            'class' => 'btn-warning',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @if($calculation)
        <div class="panel panel-alt4">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('messages.fine_results') }}</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::text('fines_min', \Formatter::money($calculation['min']), [
                            'label' => trans('messages.min'),
                            'readonly' => true,
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('fines_max', \Formatter::money($calculation['max']), [
                            'label' => trans('messages.max'),
                            'readonly' => true,
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('fines_prison', $calculation['prison'], [
                            'label' => trans('messages.prison'),
                            'readonly' => true,
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-fw-widget datatable">
                    <thead>
                    <tr>
                        <th>{{ trans('messages.fines') }}</th>
                        <th>{{ trans('messages.min') }}</th>
                        <th>{{ trans('messages.max') }}</th>
                        <th>{{ trans('messages.prison') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($calculation['data'] as $fine => $values)
                        <tr>
                            <td>{{ $fine }}</td>
                            <td>{{ \Formatter::money($values['min']) }}</td>
                            <td>{{ \Formatter::money($values['max']) }}</td>
                            <td>{{ $values['prison'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
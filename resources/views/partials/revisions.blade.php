<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ trans('messages.revision_log') }}</span>
    </div>
    <div class="margin-top-20 margin-horizontal-20">
        {!! Form::text('datatable-search', '', [
            'icon' => 'wh-search'
        ]) !!}
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-fw-widget datatable" data-order='[[5, "desc"]]'>
            <thead>
            <tr>
                <th>{{ trans('messages.user') }}</th>
                <th>{{ trans('messages.action') }}</th>
                <th>{{ trans('messages.field') }}</th>
                <th>{{ trans('messages.old_value') }}</th>
                <th>{{ trans('messages.new_value') }}</th>
                <th>{{ trans('messages.date') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($model->revisionHistory as $history)
                <tr>
                    <td>{{ object_get($history->userResponsible(), 'name', trans('messages.system')) }}</td>
                    <td>
                        @if($history->key == 'created_at' && !$history->old_value)
                            <span class="label label-success text-uppercase">{{ trans('messages.create') }}</span>
                        @else
                            <span class="label label-warning text-uppercase">{{ trans('messages.update') }}</span>
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->old_value))
                            {{ $history->fieldName() }}
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->old_value))
                            {{ $history->old_value }}
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->old_value))
                            {{ $history->new_value }}
                        @endif
                    </td>
                    <td>{{ $history->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
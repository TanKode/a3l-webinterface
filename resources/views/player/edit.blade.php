@extends('app')

@section('title', 'Spieler bearbeiten')

@section('content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="panel panel-warning">
		<div class="panel-heading"><h3 class="panel-title">Spieler bearbeiten</h3></div>
		{!! Form::model($player, array('route' => ['player.update', $player->uid], 'method' => 'post', 'class' => 'panel-body')) !!}
		<div class="row">
            @if(Auth::User()->isAllowed('edit_player_name'))
                @include('forms.input', ['col' => 3, 'name' => 'name', 'label' => 'Name'])
            @else
                Name: {{ $player->name }}
            @endif
            @if(Auth::User()->isAllowed('edit_player_id'))
                @include('forms.input', ['col' => 3, 'name' => 'playerid', 'label' => 'Spieler-ID'])
            @else
                Spieler-ID: {{ $player->playerid }}
            @endif
            @if(Auth::User()->isAllowed('edit_player_admin'))
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::label('adminlevel', 'Adminlevel', array('class' => 'input-group-addon')) !!}
                        {!! Form::select('adminlevel',range(0, \Setting::get('player.max_admin_level', 12) * 1),null,array('class'=>'form-control')) !!}
                    </div>
                </div>
            @else
                Adminlevel: {{ $player->adminlevel }}
            @endif
            @if(Auth::User()->isAllowed('edit_player_money'))
                @include('forms.input', ['col' => 2, 'name' => 'cash', 'label' => 'Bargeld'])
            @else
                    Bargeld: {{ $player->cash }}
            @endif
            @if(Auth::User()->isAllowed('edit_player_money'))
                @include('forms.input', ['col' => 2, 'name' => 'bankacc', 'label' => 'Bank'])
            @else
                    Bank: {{ $player->bankacc }}
            @endif
		</div>

		<h3>Civ</h3>
		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline">
				@foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->civ_licenses) as $licence)
					<li>
						<label for="civ_licenses-{{ $licence[0] }}" class="licenses">
						@if($licence[1])
							<span class="label label-success">
						@else
							<span class="label label-default">
						@endif
						{{ \Setting::get('licence.'.$licence[0], $licence[0]) }}</span><input type="checkbox" name="civ_licenses['{{ $licence[0] }}']" class="licenses hidden" id="civ_licenses-{{ $licence[0] }}" @if($licence[1]) checked @endif /></label>
					</li>
				@endforeach
				</ul>
			</div>
		</div>

        @if(Auth::User()->isAllowed('edit_player_cop'))
            <h3>Cop</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        {!! Form::label('coplevel', 'Level', array('class' => 'input-group-addon')) !!}
                        {!! Form::select('coplevel',range(0, \Setting::get('player.max_cop_level', 12) * 1),null,array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    <ul class="list-inline">
                        @foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->cop_licenses) as $licence)
                            <li>
                                <label for="cop_licenses-{{ $licence[0] }}" class="licenses">
                                @if($licence[1])
                                    <span class="label label-success">
                                @else
                                    <span class="label label-default">
                                @endif
                                {{ $licence[0] }}</span><input type="checkbox" name="cop_licenses['{{ $licence[0] }}']" class="licenses hidden" id="cop_licenses-{{ $licence[0] }}" @if($licence[1]) checked @endif /></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(Auth::User()->isAllowed('edit_player_med'))
            <h3>Med</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        {!! Form::label('mediclevel', 'Level', array('class' => 'input-group-addon')) !!}
                        {!! Form::select('mediclevel',range(0, \Setting::get('player.max_med_level', 12) * 1),null,array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    <ul class="list-inline">
                        @foreach(\A3LWebInterface\Libs\Formatter::decodeDBArray($player->med_licenses) as $licence)
                            <li>
                                <label for="med_licenses-{{ $licence[0] }}" class="licenses">
                                    @if($licence[1])
                                        <span class="label label-success">
                                    @else
                                        <span class="label label-default">
                                    @endif
                                    {{ $licence[0] }}</span><input type="checkbox" name="med_licenses['{{ $licence[0] }}']" class="licenses hidden" id="med_licenses-{{ $licence[0] }}" @if($licence[1]) checked @endif /></label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @include('forms.input', ['col' => 10, 'name' => 'comment', 'label' => 'Begründung'])
                <div class="col-md-1">
                    <a href="{{ url('/player/list') }}" class="btn btn-block btn-default">abbrechen</a>
                </div>
                <div class="col-md-1">
                    {!! Form::submit('speichern', array('class' => 'btn btn-danger btn-block')) !!}
                </div>
            </div>
        @endif
		{!! Form::close() !!}
	</div>

	<div class="panel panel-info">
		<div class="panel-heading"><h3 class="panel-title">Log-Verlauf</h3></div>
		@include('forms/datatables_search')
		<table class="table table-hover" data-order='[[ 0, "desc" ]]'>
			<thead>
			<tr>
				<th>Datum</th>
				<th>Bearbeiter</th>
				<th>Aktion</th>
				<th>Objekt</th>
				<th>Bemerkung</th>
			</tr>
			</thead>
			@foreach(\A3LWebInterface\Weblog::where('object_id', $player->uid)->where('table', 'players')->get() as $log)
				<tr>
					<td>{{ date('d.m.Y - H:i', strtotime($log->created_at)) }}</td>
					<td>{{ $log->editor_name }} ({{ $log->editor_id }})</td>
					<td>
						@if($log->type == 'DELETE')
							<span class="label label-danger">
						@elseif($log->type == 'UPDATE')
							<span class="label label-warning">
						@elseif($log->type == 'CREATE')
							<span class="label label-success">
						@endif
						{{ $log->type }}</span>
					</td>
					<td>{{ $log->object_name }} ({{ $log->object_id }})</td>
					<td>{{ $log->comment }}</td>
				</tr>
			@endforeach
		</table>
	</div>
@endsection
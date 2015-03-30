<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 0.5
 */
?>

<h2>Gangs @if($database == 'arma3life')<span class="label label-danger">LIVE</span>@endif</h2>

{{ Form::open(array('url'=>'gangs', 'method'=>'GET')) }}
    <div class="input-group">
        <input type="text" name="s" class="form-control" placeholder="Gang-ID || Gang-Name" value="{{ $search }}">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">suchen</button>
        </span>
    </div>
{{ Form::close() }}

@if(Session::has('message') && Session::has('type'))
    <div class="alert alert-dismissible alert-{{ Session::get('type') }}">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('message') }}
    </div>
@endif

@if(empty($search))
    {{ $gangs->links() }}
@endif

<div class="table table-hover">
    <div class="thead">
        <strong>ID</strong>
        <strong>Name</strong>
        <strong>Leiter</strong>
        <strong>Mitglieder</strong>
        <strong>max. Mitglieder</strong>
        <strong>Bankguthaben</strong>
        <strong>aktiv</strong>
        <strong></strong>
    </div>
    @foreach($gangs as $gang)
        {{ Form::open(array('url'=>'gang/edit')) }}
            <span>{{ $gang->id }}</span>
            <span>{{ $gang->name }}</span>
            <span>
                @if(Auth::user()->level >= 3)
                    {{ Form::number('owner', $gang->owner) }}
                @else
                    {{ $gang->owner }}
                @endif
            </span>
            <span id="gang_members_{{ $gang->id }}_holder">
                @if(count(Auth::user()->decodeDBArray($gang->members)))
                    <p>
                        <button class="btn btn-info btn-sm" type="button" data-parent="#gang_members_{{ $gang->id }}_holder" data-toggle="collapse" data-target="#gang_members_{{ $gang->id }}">Mitglieder</button>
                        @if(Auth::user()->level >= 2)
                            {{ Form::text('newmember', null, array('placeholder'=>'Mitglied hinzufügen')) }}
                        @endif
                    </p>
                    <div class="collapse" id="gang_members_{{ $gang->id }}">
                        @foreach(array_unique(Auth::user()->decodeDBArray($gang->members)) as $member)
                            <span class="label label-success label-list">{{ $member }}@if(Auth::user()->level >= 2) {{ Form::checkbox('member_'.$member, '1', true); }}@endif</span>
                        @endforeach
                    </div>
                @else
                    <p>keine Mitglieder</p>
                @endif
            </span>
            <span>
                @if(Auth::user()->level >= 2)
                    {{ Form::number('maxmembers', $gang->maxmembers) }}
                @else
                    {{ $gang->maxmembers }}
                @endif
            </span>
            <span>
                @if(Auth::user()->level >= 3)
                    {{ Form::number('bank', $gang->bank) }}
                @else
                    {{ number_format($gang->bank, 2, ',', '.') }}
                @endif
            </span>
            <span>
                @if(Auth::user()->level >= 3)
                    {{ Form::checkbox('active', '1', $gang->active); }}
                @else
                    @if($gang->active) ja @else nein @endif
                @endif
            </span>

            <span>
                <input type="hidden" name="gangid" value="{{ $gang->id }}" />
                <button type="submit" class="btn btn-primary btn-sm">speichern</button>
            </span>
        {{ Form::close() }}
    @endforeach
    <div class="tfoot">
        <strong>ID</strong>
        <strong>Name</strong>
        <strong>Leiter</strong>
        <strong>Mitglieder</strong>
        <strong>max. Mitglieder</strong>
        <strong>Bankguthaben</strong>
        <strong>aktiv</strong>
        <strong></strong>
    </div>
</div>

@if(empty($search))
    {{ $gangs->links() }}
@endif
<div class="col-md-{{ $col }}">
    <div class="input-group">
        {!! Form::label($name, $label, array('class' => 'input-group-addon')) !!}
        {!! Form::text($name, null, array('class' => 'form-control')) !!}
    </div>
</div>
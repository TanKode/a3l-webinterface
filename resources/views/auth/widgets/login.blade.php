{!! Form::open([
    'url' => 'auth/login',
]) !!}
{!! Form::email('email', null, [
    'placeholder' => trans('messages.email'),
    'icon' => 'wh-envelope',
    'errors' => $errors->get('email'),
]) !!}
{!! Form::password('password', [
    'placeholder' => trans('messages.password'),
    'class' => 'form-control',
    'icon' => 'wh-lock',
    'errors' => $errors->get('password'),
]) !!}
{!! Form::checkbox('remember', 1, null, [
    'label' => trans('messages.remember_me'),
]) !!}
<div class="form-group">
    {!! Form::submit(trans('messages.signin'), [
        'class' => 'btn-block btn-primary btn-lg',
    ]) !!}
</div>
{!! Form::close() !!}
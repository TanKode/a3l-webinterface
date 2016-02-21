{!! Form::open([
    'url' => 'auth/register',
]) !!}
<p>
    {{ trans('validation.alpha_dash', [
        'attribute' => trans('messages.username'),
    ]) }}
</p>
{!! Form::text('name', null, [
    'placeholder' => trans('messages.username'),
    'icon' => 'wh-user',
    'errors' => $errors->get('username'),
]) !!}
<p>Bitte trage deine ArmA-Spieler-ID ein - zu finden im Profil in ArmA.</p>
{!! Form::text('player_id', null, [
    'placeholder' => trans('messages.player_id'),
    'icon' => 'wh-steam',
    'errors' => $errors->get('player_id'),
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
{!! Form::password('password_confirmation', [
    'placeholder' => trans('messages.confirm'),
    'class' => 'form-control',
    'icon' => 'wh-lock',
    'errors' => $errors->get('password_confirmation'),
]) !!}
<div class="form-group">
    {!! Form::submit(trans('messages.signup'), [
        'class' => 'btn-block btn-primary btn-lg',
    ]) !!}
</div>
{!! Form::close() !!}
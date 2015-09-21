{!! Form::open([
    'url' => 'auth/register',
    'class' => 'text-left'
]) !!}
{!! Form::text('username', null, [
    'label' => 'Benutzername',
    'errors' => $errors->get('email'),
]) !!}
{!! Form::email('email', null, [
    'label' => 'E-Mail',
    'errors' => $errors->get('email'),
]) !!}
{!! Form::password('password', [
    'label' => 'Passwort',
    'errors' => $errors->get('password'),
]) !!}
{!! Form::password('password_confirmation', [
    'label' => 'Passwort Wiederholung',
]) !!}
{!! Form::submit('Registrieren', [
    'class' => 'btn-primary btn-block btn-lg margin-top-20',
]) !!}
{!! Form::close() !!}
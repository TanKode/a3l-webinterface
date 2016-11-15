{!! Form::open([
    'url' => 'auth/login',
    'class' => 'text-left'
]) !!}
{!! Form::email('email', null, [
    'label' => 'E-Mail',
    'errors' => $errors->get('email'),
]) !!}
{!! Form::password('password', [
    'label' => 'Passwort',
    'errors' => $errors->get('password'),
]) !!}
{!! Form::submit('Anmelden', [
    'class' => 'btn-primary btn-block btn-lg margin-top-20',
]) !!}
{!! Form::close() !!}
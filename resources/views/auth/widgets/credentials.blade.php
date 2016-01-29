<div class="tab-container">
    <ul class="nav nav-tabs">
        <li class="@if(Request::is('auth/login')) active @endif"><a href="#authLogin" data-toggle="tab">{{ trans('messages.signin') }}</a></li>
        <li class="@if(Request::is('auth/register')) active @endif"><a href="#authRegister" data-toggle="tab">{{ trans('messages.signup') }}</a></li>
    </ul>
    <div class="tab-content">
        <div id="authLogin" class="tab-pane @if(Request::is('auth/login')) active @endif cont">
            @include('auth.widgets.login')
        </div>
        <div id="authRegister" class="tab-pane @if(Request::is('auth/register')) active @endif cont">
            @include('auth.widgets.register')
        </div>
    </div>
</div>
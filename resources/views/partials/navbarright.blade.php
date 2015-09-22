<ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
    @include('partials.app.notifications')
    <li class="dropdown">
        <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
            <div class="pull-left padding-vertical-4 padding-right-15">{{ \Auth::User()->username }}</div>
            <span class="avatar avatar-online">
                <img src="{{ \Auth::User()->avatar() }}" alt="{{ \Auth::User()->username }}" />
                <i></i>
            </span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ url('app/profile/edit/' . \Auth::User()->id) }}"><i class="icon fa-user"></i>Profil</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ url('auth/logout') }}"><i class="icon fa-power-off"></i>Abmelden</a>
            </li>
        </ul>
    </li>
</ul>
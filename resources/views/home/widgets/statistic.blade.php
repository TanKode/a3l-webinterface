<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Statistik</h3></div>
        <ul class="list-group">
            <li class="list-group-item">
                Benutzer
                @if(Auth::User()->isAllowed('view_users'))
                    <a href="{{ url('/user/list') }}" class="badge">{{ \A3LWebInterface\User::count() }}</a>
                @else
                    <span class="badge">{{ \A3LWebInterface\User::count() }}</span>
                @endif
            </li>
            <li class="list-group-item">
                Spieler
                @if(Auth::User()->isAllowed('view_players'))
                    <a href="{{ url('/player/list') }}" class="badge">{{ \A3LWebInterface\Player::count() }}</a>
                @else
                    <span class="badge">{{ \A3LWebInterface\Player::count() }}</span>
                @endif
            </li>
            <li class="list-group-item">
                Fahrzeuge
                @if(Auth::User()->isAllowed('view_vehicles'))
                    <a href="{{ url('/vehicle/list') }}" class="badge">{{ \A3LWebInterface\Vehicle::count() }}</a>
                @else
                    <span class="badge">{{ \A3LWebInterface\Vehicle::count() }}</span>
                @endif
            </li>
            <li class="list-group-item">
                Gangs
                @if(Auth::User()->isAllowed('view_gangs'))
                    <a href="{{ url('/gang/list') }}" class="badge">{{ \A3LWebInterface\Gang::count() }}</a>
                @else
                    <span class="badge">{{ \A3LWebInterface\Gang::count() }}</span>
                @endif
            </li>
        </ul>
    </div>
</div>
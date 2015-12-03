<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Serveradressen</h3></div>
        <ul class="list-group">
            @foreach(\Setting::get('info') as $key => $info)
                <li class="list-group-item">
                    {{ ucwords(implode(' ', explode('_', $key))) }}
                    @if(strpos($info, 'http') === 0)
                        <a href="{{ $info }}" class="badge" target="_blank">{{ preg_replace('#^http(s)?://#', '', $info) }}</a>
                    @else
                        <span class="badge">{{ $info }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
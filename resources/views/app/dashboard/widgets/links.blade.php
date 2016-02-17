<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ trans('messages.links') }}</span>
    </div>
    <div class="list-group">
        @foreach(config('a3l.links') as $link)
            <a href="{{ url($link['url']) }}" class="list-group-item" @if(starts_with($link['url'], 'http')) target="_blank" @endif>
                <i class="icon {{ $link['icon'] }}"></i>
                {{ $link['name'] }}
            </a>
        @endforeach
    </div>
</div>
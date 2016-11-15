<li class="list-group-item">
	<div class="media">
		<div class="media-left">
            <a href="{{ url('app/profile/show/'.$post->author->id) }}"><img src="{{ $post->author->avatar() }}" alt="{{ $post->authorName }}" class="avatar" /></a>
		</div>
		<div class="media-body">
			<small class="text-muted pull-right">{{ $post->created_at->diffForHumans() }}</small>
            @if ($post->canEdit)
                <a class="pull-right" href="{{ $post->editRoute }}"><i class="icon fa-pencil text-warning"></i></a>
            @endif
            @if ($post->canDelete)
                <a class="pull-right" href="{{ $post->deleteRoute }}" data-confirm data-method="delete"><i class="icon fa-trash-o text-danger"></i></a>
            @endif
			<h4 class="media-heading">
                <a href="{{ url('app/profile/show/'.$post->author->id) }}">{{ $post->authorName }}</a>
                <span class="label label-default label-outline">{{ $post->author->role->name }}</span>
            </h4>
			<div>
                {!! \MarkExtra::defaultTransform(e($post->content.PHP_EOL.PHP_EOL.PHP_EOL.$post->author->signature)) !!}
            </div>
		</div>
	</div>
</li>
<li class="list-group-item">
	<div class="media">
		<div class="media-left">
            <img src="{{ $post->author->avatar() }}" alt="{{ $post->authorName }}" class="avatar" />
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
                {{ $post->authorName }}
                <span class="label label-default label-outline">{{ $post->author->role->name }}</span>
            </h4>
			<div>
                {!! \MarkExtra::defaultTransform(e($post->content)) !!}
            </div>
		</div>
	</div>
</li>
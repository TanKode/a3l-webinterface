<aside class="page-aside">
    <div class="am-scroller nano has-scrollbar">
        <div class="nano-content">
            <div class="content">
                <div class="aside-header clearfix margin-0">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".aside-nav"><span class="icon wh-chevron-down"></span></button>
                    <h2 class="pull-left margin-0">{{ trans('menu.forum') }}</h2>
                </div>
            </div>
            <div class="aside-nav collapse">
                <ul class="nav">
                    <li><a href="{{ url('app/forum') }}"><i class="icon wh-forumsalt"></i> {{ trans('forum::general.index') }}</a></li>
                </ul>
                @foreach($categoryList as $category)
                <p class="title">{{ $category->title }}</p>
                <ul class="nav">
                    @if(!$category->children->isEmpty())
                        @foreach($category->children as $subcategory)
                            <li><a href="{{ url('app/forum/category/' . $subcategory->getKey()) }}"><i class="icon wh-forumsalt"></i> {{ $subcategory->title }}</a></li>
                        @endforeach
                    @endif
                </ul>
                @endforeach

                @can('createCategories')
                <div class="aside-compose">
                    <a href="{{ url('app/forum/category/create') }}" class="btn btn-primary btn-block">{{ trans('forum::categories.create') }}</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</aside>
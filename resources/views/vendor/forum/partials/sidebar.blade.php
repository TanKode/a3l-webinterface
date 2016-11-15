<div class="page-aside">
    <div class="page-aside-switch">
        <i class="icon fa-chevron-left"></i>
        <i class="icon fa-chevron-right"></i>
    </div>
    <div class="page-aside-inner">
        @foreach ($categories as $category)
            <section class="page-aside-section">
                <h5 class="page-aside-title">
                    <a href="{{ $category->route }}">{{ $category->title }}</a>
                    <span class="pull-right badge">{{ $category->threadCount }}</span>
                </h5>
                @if (!$category->subcategories->isEmpty())
                    <div class="list-group">
                        @foreach ($category->subcategories as $subcategory)
                        <a class="list-group-item" href="{{ $subcategory->route }}">
                            <i class="icon fa-comments-o"></i>
                            <span class="list-group-item-content">{{ $subcategory->title }}</span>
                            <span class="pull-right badge">{{ $subcategory->threadCount }}</span>
                        </a>
                        @endforeach
                    </div>
                @endif
            </section>
        @endforeach
    </div>
</div>
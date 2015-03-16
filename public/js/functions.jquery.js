jQuery(window).on('load', function() {
    var $masonryContainer = jQuery('.masonry-container');
    initializeMasonry();

    var $buttons = jQuery('.btn-filter');
    var $items = jQuery('.item');
    $buttons.on('click', function() {
        $buttons.removeClass('btn-success').addClass('btn-default');
        jQuery(this).removeClass('btn-default').addClass('btn-success');
        $items.fadeOut(400).removeClass('masonry-item');
        $masonryContainer.masonry('destroy');
        var $this = jQuery(this);
        var type = $this.attr('data-filter');
        if(type == 'all') {
            $items.fadeIn(400).addClass('masonry-item');
            initializeMasonry();
        } else {
            $masonryContainer.find('.type-' + type).fadeIn(400).addClass('masonry-item');
            initializeMasonry();
        }
    });

    function initializeMasonry() {
        $masonryContainer.masonry({
            itemSelector: '.masonry-item'
        });
    }
});
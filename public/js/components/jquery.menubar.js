jQuery('[data-toggle="menubar"]').on('click', function() {
    jQuery.jStorage.set('menubar-fold', $(this).find('i').hasClass('unfolded'));
});
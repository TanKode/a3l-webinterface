jQuery('body').on('site.init', function () {
    jQuery('[data-reset]').on('click', function () {
        var $this = jQuery(this);
        var $input = jQuery($this.data('reset'));
        $input.val('').trigger('change').trigger('keypress').trigger('keydown').trigger('keyup');
    });
});
var App = (function () {
    App.licenses = function () {
        'use strict'

        jQuery('label.license').on('click', function () {
            console.log('clicked');
            var $this = jQuery(this);
            $this.toggleClass('label-success').toggleClass('label-dark');
            var $input = $this.find('input').first();
            if($input.val() == 1) {
                $input.val(0);
            } else {
                $input.val(1);
            }
        });

    };
    return App;
})(App || {});
var App = (function () {
    App.masonry = function () {
        'use strict'

        function masonry() {
            $('.masonry-container').masonry({
                columnWidth: '.masonry-sizer',
                itemSelector: '.masonry-item',
                percentPosition: true
            });
        }

    masonry();

    };
    return App;
})(App || {});
jQuery(window).on('load', function () {
    loader().hide();
});

function loader() {
    return jQuery('#site-loader');
}
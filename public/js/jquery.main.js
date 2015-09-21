// extend String object
String.prototype.htmlEntities = function () {
    return this.replace(/&amp;/g, "&");
};
String.prototype.plain = function () {
    return this.replace(/^\s+|\s+$/g, "").replace(/<.*?>/g, "").toLowerCase();
};
String.prototype.umlauts = function () {
    return this.replace(/^\s+|\s+$/g, "").replace(/ä/g, "a").replace(/ö/g, "u").replace(/ü/g, "u").replace(/ß/g, "s");
};

jQuery(window).on('load', function () {
    if(jQuery.jStorage.get('menubar-fold', false)) {
        jQuery('body').addClass('site-menubar-fold');
    }
    var Site = window.Site;
    Site.run();
    jQuery('body').trigger('site.init')
});

jQuery('body').on('site.init', function () {
    jQuery('#site-loader').hide();
});
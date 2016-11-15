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
String.prototype.money = function () {
    return this.replace(/\D+/g, "") * 1;
};

jQuery(window).on('load', function () {
    if(jQuery.jStorage.get('menubar-fold', false)) {
        jQuery('body').addClass('site-menubar-fold');
    }

    jQuery('a[data-confirm]').on('click', function(e) {
        if (!confirm('Löschen?')) {
            e.stopImmediatePropagation();
            e.preventDefault();
        }
    });
    jQuery("a[data-method='post']").on('click', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        jQuery('<form action="' + jQuery(this).attr('href') + '" method="POST">' +
            '<input type="hidden" name="_method" value="' + jQuery(this).data('method') + '">' +
            '<input type="hidden" name="_token" value="' + jQuery("input[name=csrf_token]").val() + '">' +
            '</form>').submit();
    });

    var Site = window.Site;
    Site.run();
    jQuery('body').trigger('site.init');

});

jQuery('body').on('site.init', function () {
    jQuery('#site-loader').hide();
});
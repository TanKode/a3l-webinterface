jQuery('body').on('site.init', function () {
    var $listjs = jQuery('#listjs');
    if($listjs.length == 1) {
        var $sort = $listjs.find('.sort');
        var $search = $listjs.find('.search');
        var defaults = {
            insensitive: true
        };

        var options = jQuery.extend(true, {}, defaults, $listjs.data('options'));
        var listjs = new List('listjs', options);

        if($sort.length > 0) {
            $sort.on('change', function () {
                var $this = jQuery(this);
                listjs.sort($this.val(), {order: "asc"});
            });
            listjs.sort($sort.val(), {order: "asc"});
        }

        if($search.length > 0) {
            $search.on('keypress', function () {
                var $this = jQuery(this);
                listjs.search($this.val());
            });
            listjs.search($search.val());
        }
    }
});
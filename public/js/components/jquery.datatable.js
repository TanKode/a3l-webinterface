// extend dataTables sort & search
jQuery.fn.dataTableExt.oSort['german-asc'] = function (a, b) {
    a = a.plain().umlauts();
    b = b.plain().umlauts();
    return (a == b) ? 0 : (a > b) ? 1 : -1;
};
jQuery.fn.dataTableExt.oSort['german-desc'] = function (a, b) {
    a = a.plain().umlauts();
    b = b.plain().umlauts();
    return (a == b) ? 0 : (a > b) ? -1 : 1;
};
jQuery.fn.dataTableExt.ofnSearch['german'] = function (a) {
    a = a.plain();
    var b = a.umlauts();
    return a + ' ' + b;
};

jQuery('body').on('site.init', function () {
    var $dataTable = $.fn.dataTable.tables({visible: true, api: false});
    if ($dataTable.length > 0) {
        $dataTable = $($dataTable[0]).dataTable().api();

        $dataTable.on('draw', function () {
            jQuery($dataTable.table().container())
                .find('.dataTables_paginate')
                .css('display', $dataTable.page.info().pages <= 1 ? 'none' : 'block')
        });

        $dataTable.columns().every(function () {
            var column = this;
            var searchKey = jQuery(column.header()).data('search-key');
            var $input = jQuery('#' + searchKey + 'Filter');

            if ($input.length == 1) {
                if ($input.data('typeahead') == 1) {
                    var d = $.map(column.data().unique(), function (value, index) {
                        value = value.htmlEntities();
                        var key = value.plain().umlauts();
                        var obj = {};
                        obj[key + ' ' + value] = value;
                        return obj;
                    });
                    var data = new Bloodhound({
                        datumTokenizer: function (d) {
                            for (var prop in d) {
                                return Bloodhound.tokenizers.whitespace(prop);
                            }
                        },
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: d
                    });
                    $input.typeahead({hint: true, highlight: true, minLength: 1}, {
                        name: searchKey,
                        source: data.ttAdapter(),
                        limit: 20,
                        displayKey: function (stocks) {
                            for (var prop in stocks) {
                                if (prop != '_query') {
                                    return stocks[prop];
                                }
                            }
                        }
                    });
                }

                $input.on('change focusout', function () {
                    jQuery('#filter').trigger('filter.datatable.run');
                });
            }
        });
        $dataTable.draw();
        jQuery('#filter').trigger('filter.datatable.run');
    }
});
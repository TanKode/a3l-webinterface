var App = (function () {
    'use strict';

    App.dataTable = function () {
        jQuery.extend(true, $.fn.dataTable.defaults, {
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            dom: "<tr>" +
            "<'row am-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [
                {
                    targets: 'noindex',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        var datatable = jQuery(".datatable").first().DataTable();

        jQuery('[name=datatable-search]').on('keyup', function () {
            datatable.search( jQuery(this).val() ).draw();
        });
    };
    return App;
})(App || {});

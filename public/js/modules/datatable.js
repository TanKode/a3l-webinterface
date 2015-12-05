var App = (function () {
    'use strict';

    App.dataTable = function () {
        jQuery.extend(true, $.fn.dataTable.defaults, {
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            dom: "<f>" +
            "<tr>" +
            "<'row am-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [
                {
                    targets: 'noindex',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        jQuery(".datatable").dataTable();
    };
    return App;
})(App || {});

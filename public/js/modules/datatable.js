var App = (function () {
    'use strict';

    App.dataTable = function () {
        jQuery.extend(true, $.fn.dataTable.defaults, {
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

        var $table =jQuery(".datatable").first();
        var $vehicleTable = jQuery('#datatable-vehicle').first();
        if($table.length == 1 || $vehicleTable.length == 1) {
            var datatable = $table.DataTable();
            var vehicleDatatable = $vehicleTable.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "vehicle/datatable"
                },
                "columns": [
                    {"data": "id"},
                    {"data": "pid"},
                    {"data": "side"},
                    {"data": "type"},
                    {"data": "name"},
                    {"data": "classname"},
                    {"data": "alive"},
                    {"data": "active"},
                    {"data": "btns"}
                ]
            });

            var $searchField = jQuery('[name=datatable-search]');
            $searchField.on('keyup change blur', function () {
                datatable.search(jQuery(this).val()).draw();
                vehicleDatatable.search(jQuery(this).val()).draw();
            });
            datatable.search($searchField.val()).draw();
            vehicleDatatable.search($searchField.val()).draw();
        }
    };
    return App;
})(App || {});

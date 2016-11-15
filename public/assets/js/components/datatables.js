/*!
 * remark v1.0.5 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("dataTable", {
    defaults: {
        responsive: true,
        language: {
            "sSearchPlaceholder": "Search..",
            "lengthMenu": "_MENU_",
            "search": "_INPUT_",
            "paginate": {
                "previous": '<i class="icon wb-chevron-left-mini"></i>',
                "next": '<i class="icon wb-chevron-right-mini"></i>'
            }
        }
    },
    api: function() {
        if (!$.fn.dataTable) return;

        if ($.fn.dataTable.TableTools) {
            // Set the classes that TableTools uses to something suitable for Bootstrap
            $.extend(true, $.fn.dataTable.TableTools.classes, {
                "container": "DTTT btn-group btn-group pull-left",
                "buttons": {
                    "normal": "btn btn-outline btn-default",
                    "disabled": "disabled"
                },
                "print": {
                    "body": "site-print DTTT_Print"
                }
            });
        }
    },
    init: function(context) {
        if (!$.fn.dataTable) return;

        var defaults = $.extend(true, {}, $.components.getDefaults("dataTable"), $('body').data('datatables-defaults'));

        $('[data-plugin="dataTable"]', context).each(function() {
            var options = $.extend(true, {}, defaults, $(this).data('options'));
            $(this).dataTable(options);
        });
    }
});

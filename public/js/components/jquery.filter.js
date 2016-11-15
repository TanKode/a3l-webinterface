jQuery('#resetFilter').on('click', function () {
    jQuery('#filter').trigger('filter.reset');
});


jQuery('#filter').on('filter.datatable.run', function () {
    var $dataTable = $.fn.dataTable.tables({visible: true, api: false});
    if ($dataTable.length > 0) {
        $dataTable = $($dataTable[0]).dataTable().api();
        $dataTable.columns().every(function () {
            var column = this;
            var searchKey = jQuery(column.header()).data('search-key');
            var $input = jQuery('#' + searchKey + 'Filter');

            if ($input.length == 1) {
                column.search($input.val()).draw();
            }
        });
    }
});

jQuery('#filter').on('filter.reset', function () {
    var $inputs = jQuery(this).find('.panel-body').find('.form-control');
    $inputs.each(function (i) {
        var $this = jQuery($inputs[i]);
        if ($this.attr('id') != undefined) {
            if ($this.data('plugin') == 'selectpicker') {
                $this.selectpicker('val', $this.data('default'));
            } else {
                $this.val($this.data('default'));
            }
        }
    });
    jQuery('#filter').trigger('filter.datatable.run');
});
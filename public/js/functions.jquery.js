jQuery(window).on('load', function() {
    var $datepicker = jQuery( '.datepicker' );
    $datepicker.datepicker();
    $datepicker.datepicker( 'option', 'dateFormat', 'yy-mm-dd' );
    jQuery.each($datepicker, function( i, val ) {
        $this = jQuery( this );
        $this.datepicker( 'setDate', $this.attr( 'data-value' ) );
    });
});
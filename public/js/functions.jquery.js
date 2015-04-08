jQuery( window ).on('load', function() {
    jQuery('[data-toggle="tooltip"]').tooltip();

    var $datepicker = jQuery( '.datepicker' );
    $datepicker.datepicker();
    $datepicker.datepicker( 'option', 'dateFormat', 'yy-mm-dd' );
    jQuery.each($datepicker, function() {
        $this = jQuery( this );
        $this.datepicker( 'setDate', $this.attr( 'data-value' ) );
    });

    jQuery.widget( 'custom.catcomplete', jQuery.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu( 'option', 'items', '> :not(.ui-autocomplete-category)' );
        },

        _renderMenu: function( ul, items ) {
            var that = this, currentCategory = '';
            jQuery.each( items, function( index, item ) {
                var li;
                if ( item.category != currentCategory ) {
                    ul.append( '<li class="ui-autocomplete-category">' + item.category + '</li>' );
                    currentCategory = item.category;
                }
                li = that._renderItemData( ul, item );
                if ( item.category ) {
                    li.attr( 'aria-label', item.category + ' : ' + item.label );
                }
            });
        }
    });

    var reasonData = [
        { label: '[BUG] Fahrzeug ist beim einsteigen explodiert', category: 'BUG' },
        { label: '[BUG] Fahrzeug ist beim fliegen explodiert', category: 'BUG' },
        { label: '[BUG] Fahrzeug ist beim fahren explodiert', category: 'BUG' },
        { label: '[BUG] Fahrzeug-Inventar nicht aufrufbar', category: 'BUG' },
        { label: '[BUG] Lizenz ist verschwunden', category: 'BUG' },
        { label: '[BUG] Geld ist verschwunden', category: 'BUG' },
        { label: '[BUG] Fall-Bug von Stein/Mäuerchen', category: 'BUG' },

        { label: '[BUGUSING] Account-Reset wegen Inventar-Double-Bugusing', category: 'BUGUSING' },
        { label: '[BUGUSING] Account-Reset wegen xyz-Bugusing', category: 'BUGUSING' },

        { label: '[DDOS] Fahrzeug verloren', category: 'DDOS' },
        { label: '[DDOS] Equipment verloren', category: 'DDOS' },

        { label: '[DONATOR] Hat x € für x Monate Donator via PaySafeCard gespendet', category: 'DONATOR' },
        { label: '[DONATOR] Hat x € für x Monate Donator via PayPal gespendet', category: 'DONATOR' },
        { label: '[DONATOR] Hat x € für x Monate Donator via Überweisung gespendet', category: 'DONATOR' },
        { label: '[DONATOR] Lizenz hinzugefügt', category: 'DONATOR' },
        { label: '[DONATOR] Lizenz entfernt', category: 'DONATOR' },

        { label: '[DESYNC] Fahrzeug ist in anderes Fahrzeug gedesynct', category: 'DESYNC' },
        { label: '[DESYNC] Fahrzeug ist in Gebäude gedesynct', category: 'DESYNC' },

        { label: '[GANG] Mitglied hinzugefügt', category: 'GANG' },
        { label: '[GANG] Mitglied entfernt', category: 'GANG' },
        { label: '[GANG] Mitglieder gesäubert', category: 'GANG' },
        { label: '[GANG] Leiter geändert', category: 'GANG' },

        { label: '[RANG] COP hinzugefügt', category: 'RANG' },
        { label: '[RANG] COP-Level geändert', category: 'RANG' },
        { label: '[RANG] COP entfernt', category: 'RANG' },
        { label: '[RANG] MEDIC hinzugefügt', category: 'RANG' },
        { label: '[RANG] MEDIC-Level geändert', category: 'RANG' },
        { label: '[RANG] MEDIC entfernt', category: 'RANG' },
        { label: '[RANG] ADAC hinzugefügt', category: 'RANG' },
        { label: '[RANG] ADAC-Level geändert', category: 'RANG' },
        { label: '[RANG] ADAC entfernt', category: 'RANG' },

        { label: '[RANG] TAXI hinzugefügt', category: 'RANG' },
        { label: '[RANG] TAXI entfernt', category: 'RANG' },
        { label: '[RANG] BUS hinzugefügt', category: 'RANG' },
        { label: '[RANG] BUS entfernt', category: 'RANG' },

        { label: '[SUPPORT] VDM Fahrzeug gegen Fahrzeug', category: 'SUPPORT' },
        { label: '[SUPPORT] VDM Fahrzeug gegen Person', category: 'SUPPORT' },
        { label: '[SUPPORT] RDM Items erstattet', category: 'SUPPORT' },
        { label: '[SUPPORT] Datenbank-Fehler erstattet', category: 'SUPPORT' },
        { label: '[SUPPORT] Verbindung verloren', category: 'SUPPORT' },
        { label: '[SUPPORT] Ermahnung: xyz', category: 'SUPPORT' },
    ];

    jQuery( '.reason-input' ).catcomplete({
        delay: 0,
        minLength: 0,
        source: reasonData
    }).focus(function(){
        jQuery(this).catcomplete("search");
    });
});
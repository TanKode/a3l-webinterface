var App = (function () {
    'use strict';

    App.statlog = function () {
        var colorPlayer = App.color.primary;
        var colorCop = App.color.info;
        var colorMedic = App.color.danger;
        var colorAtac = App.color.warning;
        var colorGang = App.color.alt4;

        // Player Chart
        function count_chart() {
            new Morris.Line({
                element: 'countChart',
                data: jQuery('#countChart').data('datas'),
                xkey: 'created_at',
                ykeys: ['player_count', 'cop_count', 'medic_count', 'atac_count', 'gang_count'],
                labels: ['Player', 'Cops', 'Medics', 'ATACs', 'Gangs'],
                lineColors: [colorPlayer, colorCop, colorMedic, colorAtac, colorGang]
            });
        }

        // Money Chart
        function money_chart() {
            new Morris.Line({
                element: 'moneyChart',
                data: jQuery('#moneyChart').data('datas'),
                xkey: 'created_at',
                ykeys: ['player_money', 'gang_money'],
                labels: ['Spieler-Geld', 'Gang-Geld'],
                lineColors: [colorPlayer, colorGang]
            });
        }

        if (jQuery('#countChart').length == 1) {
            count_chart();
        }
        if (jQuery('#moneyChart').length == 1) {
            money_chart();
        }
    };

    return App;
})(App || {});
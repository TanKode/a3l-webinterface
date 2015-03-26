<?php
/**
 * ide: PhpStorm
 * author: Gummibeer
 * url: https://bitbucket.org/Gummibeer
 * package: a3l_admintool
 * since 1.0
 */
?>

<h2>Statistik</h2>

<div class="row">
    <div class="col-md-6"><div id="chart_players" class="chart_container"></div></div>
    <div class="col-md-6"><div id="chart_donator" class="chart_container"></div></div>
    <div class="col-md-6"><div id="chart_money" class="chart_container"></div></div>
    <div class="col-md-6"><div id="chart_vehicles" class="chart_container"></div></div>
    <div class="col-md-6"><div id="chart_houses" class="chart_container"></div></div>
    <div class="col-md-6"><div id="chart_gangs" class="chart_container"></div></div>
</div>

<script type="text/javascript">
    jQuery(function () {
        Highcharts.setOptions({
            lang: {
                shortMonths: [ "Jan" , "Feb" , "Mär" , "Apr" , "Mai" , "Jun" , "Jul" , "Aug" , "Sep" , "Okt" , "Nov" , "Dez"],
                weekdays: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"]
            }
        });

        jQuery('#chart_players').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Spieler-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Spieler',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->players }},@endforeach]
            }]
        });

        jQuery('#chart_money').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Geld-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Euro',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->bankacc + $statistic->cash }},@endforeach]
            }]
        });

        jQuery('#chart_vehicles').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Fahrzeug-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Fahrzeuge',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->vehicles }},@endforeach]
            }]
        });

        jQuery('#chart_houses').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Häuser-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Häuser',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->houses }},@endforeach]
            }]
        });

        jQuery('#chart_gangs').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Gang-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Gangs',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->gangs }},@endforeach]
            }]
        });

        jQuery('#chart_donator').highcharts({
            chart: { zoomType: 'x' },
            title: { text: 'Altis Life Server Donator-Verlauf' },
            subtitle: { text: document.ontouchstart === undefined ? 'Bereich zum zoomen markieren.' : 'Pinch the chart to zoom in' },
            xAxis: { type: 'datetime', minRange: 28 * 24 * 60 * 60 * 1000 },
            yAxis: { title: { text: 'Summe' } },
            legend: { enabled: false },
            plotOptions: {
                area: {
                    fillColor: { linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1}, stops: [ [0, Highcharts.Color('#df691a').setOpacity(1).get('rgba')], [1, Highcharts.Color('#df691a').setOpacity(0).get('rgba')] ] },
                    marker: { radius: 2, fillColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba') },
                    lineColor: Highcharts.Color('#df691a').setOpacity(1).get('rgba'),
                    lineWidth: 1,
                    states: { hover: { lineWidth: 1 } },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Donator',
                pointInterval: 4 * 60 * 60 * 1000,
                pointStart: Date.UTC(2015, 2, 26, 16),
                data: [@foreach($statistics as $statistic){{ $statistic->donator }},@endforeach]
            }]
        });
    });
</script>
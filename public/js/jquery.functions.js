jQuery(window).on('load', function () {
    var $table = jQuery('table.table').not('.dt-exclude').first();
    if($table.length == 1) {
		$.fn.dataTableExt.oPagination.four_button = {
			"fnInit": function ( oSettings, nPaging, fnCallbackDraw ) {
				nFirst = document.createElement( 'span' );
				nPrevious = document.createElement( 'span' );
				nCurrent = document.createElement( 'span' );
				nInfo = document.createElement( 'span' );
				nNext = document.createElement( 'span' );
				nLast = document.createElement( 'span' );

				nFirst.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sFirst ) );
				nPrevious.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sPrevious ) );
				nCurrent.appendChild( document.createTextNode( Math.ceil(oSettings.fnDisplayEnd() / oSettings._iDisplayLength)+'' ) );
				nInfo.appendChild( document.createTextNode( oSettings._iDisplayStart + ' - ' + oSettings.fnDisplayEnd() + ' | ' + oSettings.fnRecordsDisplay()+'' ) );
				nNext.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sNext ) );
				nLast.appendChild( document.createTextNode( oSettings.oLanguage.oPaginate.sLast ) );

				nFirst.className = "btn btn-default first";
				nPrevious.className = "btn btn-default previous";
				nCurrent.className = "btn btn-primary";
				nInfo.className = "btn btn-info";
				nNext.className="btn btn-default next";
				nLast.className = "btn btn-default last";

				nPaging.className = 'btn-group btn-group-justified';

				nPaging.appendChild( nFirst );
				nPaging.appendChild( nPrevious );
				nPaging.appendChild( nCurrent );
				nPaging.appendChild( nInfo );
				nPaging.appendChild( nNext );
				nPaging.appendChild( nLast );

				$(nFirst).on('click', function () {
					oSettings.oApi._fnPageChange( oSettings, "first" );
					fnCallbackDraw( oSettings );
				} );

				$(nPrevious).on('click', function() {
					oSettings.oApi._fnPageChange( oSettings, "previous" );
					fnCallbackDraw( oSettings );
				} );

				$(nNext).on('click', function() {
					oSettings.oApi._fnPageChange( oSettings, "next" );
					fnCallbackDraw( oSettings );
				} );

				$(nLast).on('click', function() {
					oSettings.oApi._fnPageChange( oSettings, "last" );
					fnCallbackDraw( oSettings );
				} );
			},
			"fnUpdate": function ( oSettings, fnCallbackDraw ) {
				if ( !oSettings.aanFeatures.p ) {
					return;
				}

				var an = oSettings.aanFeatures.p;
				for ( var i=0, iLen=an.length ; i<iLen ; i++ ) {
					var buttons = an[i].getElementsByTagName('span');
					if ( oSettings._iDisplayStart === 0 ) {
						buttons[0].className = "btn btn-default disabled";
						buttons[1].className = "btn btn-default disabled";
					} else {
						buttons[0].className = "btn btn-default";
						buttons[1].className = "btn btn-default";
					}

					buttons[2].className = "btn btn-primary no-hover";
					buttons[3].className = "btn btn-info no-hover";
					jQuery(buttons[2]).text( Math.ceil(oSettings.fnDisplayEnd() / oSettings._iDisplayLength)+'' );
					jQuery(buttons[3]).text( oSettings._iDisplayStart + ' - ' + oSettings.fnDisplayEnd() + ' | ' + oSettings.fnRecordsDisplay()+'' );

					if ( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() ) {
						buttons[4].className = "btn btn-default disabled";
						buttons[5].className = "btn btn-default disabled";
					} else {
						buttons[4].className = "btn btn-default";
						buttons[5].className = "btn btn-default";
					}
				}
			}
		};

		var datatable = $table.DataTable({
			sDom: 'ptp',
			sPaginationType: 'four_button',
			iDisplayLength: 50
		});
		new $.fn.dataTable.FixedHeader( datatable );

		jQuery('#datatables-search').on('keyup', function () {
			datatable.search( jQuery(this).val() ).draw();
		});

		jQuery('#datatables-search-btn').on('click', function () {
			jQuery('#datatables-search').val('');
			datatable.search('').draw();
		});
    }

    var $serverCpuChart = jQuery('#server-cpu-chart');
    if($serverCpuChart.length == 1) {
        function formatJSON(input) {
            return jQuery.parseJSON(input);
        }

        var result = formatJSON($serverCpuChart.attr('data-load'));
        var linechartdata = {
            labels: ['jetzt'],
            datasets : [
                {
                    label: 'CPU-Auslastung',
                    scaleGridLineColor : '#f0f0f0',
                    fillColor: 'transparent',
                    strokeColor: '#C65444',
                    pointColor: '#C65444',
                    pointStrokeColor: '#C65444',
                    pointHighlightFill: '#C65444',
                    pointHighlightStroke: '#C65444',
                    data: [0]
                },
                {
                    label: 'RAM-Auslastung',
                    scaleGridLineColor : '#f0f0f0',
                    fillColor: 'transparent',
                    strokeColor: '#F9C23D',
                    pointColor: '#F9C23D',
                    pointStrokeColor: '#F9C23D',
                    pointHighlightFill: '#F9C23D',
                    pointHighlightStroke: '#F9C23D',
                    data: [0]
                },
                {
                    label: 'HDD-Belegung',
                    scaleGridLineColor : '#f0f0f0',
                    fillColor: 'transparent',
                    strokeColor: '#2D8332',
                    pointColor: '#2D8332',
                    pointStrokeColor: '#2D8332',
                    pointHighlightFill: '#2D8332',
                    pointHighlightStroke: '#2D8332',
                    data: [0]
                }
            ]
        };
        var ctx = document.getElementById("server-cpu-chart").getContext("2d");
        window.serverCpuLoad = new Chart(ctx).Line(linechartdata, {
            responsive: true,
            bezierCurve : false,
            pointDot : false
        });

        window.serverCpuLoad.removeData();
        jQuery.each(result, function(i) {
            window.serverCpuLoad.addData([result[i].cpu, result[i].ram, result[i].hdd], result[i].time);
        });

        //var interval = 30;
        //setInterval(function() {
        //    jQuery.get('/sys/load', function( data ) {
        //        var result = formatJSON(data);
        //        window.serverCpuLoad.addData([result.cpu, result.ram, result.hdd], result.time);
        //    });
        //}, 1000 * interval);
    }

    jQuery('[data-toggle="tooltip"]').tooltip();

    var $container = jQuery('.masonry-container');
    $container.masonry({
        itemSelector: '.masonry-item'
    });

	jQuery('input[type=checkbox].licenses').on('change', function() {
		var $this = jQuery(this);
		$this.parent('label').find('.label').toggleClass('label-success').toggleClass('label-default');
	});
});
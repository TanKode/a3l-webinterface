<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private $css = [
        'assets/css/bootstrap.min.css',
        'assets/css/bootstrap-extend.min.css',
        'css/theme.min.css',
        'assets/vendor/asscrollable/asScrollable.min.css',
        'assets/vendor/flag-icon-css/flag-icon.min.css',
        'assets/vendor/bootstrap-select/bootstrap-select.css',
        'assets/vendor/datatables-bootstrap/dataTables.bootstrap.css',
        'assets/vendor/typeahead-js/typeahead.min.css',
        'assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css',
        'assets/vendor/bootstrap-markdown/bootstrap-markdown.min.css',

        'fonts/web-icons/web-icons.min.css',
        'fonts/brand-icons/brand-icons.min.css',
        'fonts/font-awesome/font-awesome.min.css',
        'css/styles.min.css' // LAST
    ];

    private $js = [
        'head' => [
            'assets/vendor/modernizr/modernizr.min.js',
            'assets/vendor/breakpoints/breakpoints.min.js',
        ],
        'foot' => [
            'assets/vendor/jquery/jquery.min.js',
            'assets/vendor/bootstrap/bootstrap.min.js',

            'assets/vendor/asscroll/jquery-asScroll.min.js',
            'assets/vendor/mousewheel/jquery.mousewheel.min.js',
            'assets/vendor/asscrollable/jquery.asScrollable.all.min.js',
            'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js',
            'assets/vendor/bootstrap-select/bootstrap-select.min.js',
            'assets/vendor/datatables/jquery.dataTables.js',
            'assets/vendor/datatables-bootstrap/dataTables.bootstrap.js',
            'assets/vendor/typeahead-js/typeahead.bundle.min.js',
            'assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js',
            'assets/vendor/masonry/masonry.pkgd.min.js',
            'assets/vendor/bootstrap-markdown/bootstrap-markdown.js',
            'assets/vendor/marked/marked.min.js',
            'assets/vendor/to-markdown/to-markdown.js',

            'assets/js/core.min.js',
            'assets/js/site.min.js',

            'assets/js/configs/config-colors.min.js',

            'assets/js/sections/menu.min.js',
            'assets/js/sections/menubar.min.js',
            'assets/js/sections/sidebar.min.js',

            'assets/js/components/asscrollable.min.js',
            'assets/js/components/panel.min.js',
            'assets/js/components/bootstrap-select.min.js',
            'assets/js/components/datatables.min.js',
            'assets/js/components/bootstrap-datepicker.min.js',
            'assets/js/components/masonry.min.js',

            'js/libs/jquery.jstorage.min.js',
            'js/libs/list.min.js',
            'js/libs/jquery.bootstrap-suggest.js',
            'js/jquery.main.js',
            'js/components/jquery.datatable.js',
            'js/components/jquery.menubar.js',
            'js/components/jquery.list.js',
            'js/components/jquery.inputs.js',
            'js/components/jquery.filter.js',
            'js/components/jquery.markdown.js',
            'js/components/jquery.suggest.js',

            'js/bootstrap-datepicker.de.js',
        ],
    ];

    private $dtDefaults = [];

    public function boot()
    {
        $this->dtDefaults = [
            'dom' => 'tip',
            'pageLength' => 25,
            'columnDefs' => [
                [
                    'targets' => 'german',
                    'type' => 'german',
                ],
                [
                    'targets' => 'money',
                    'type' => 'money',
                ],
                [
                    'targets' => 'noindex',
                    'orderable' => false,
                    'searchable' => false,
                ],
            ],
            'language' => [
                'emptyTable' => 'Keine Daten in der Tabelle vorhanden',
                'info' => '_START_ bis _END_ von _TOTAL_ Einträgen',
                'infoEmpty' => 'Keine Einträge vorhanden.',
                'infoFiltered' => '(gefiltert von _MAX_ Einträgen)',
                'infoPostFix' => '',
                'infoThousands' => '.',
                'lengthMenu' => '_MENU_ Einträge anzeigen',
                'loadingRecords' => 'Wird geladen ...',
                'processing' => 'Bitte warten ...',
                'search' => 'Suchen',
                'zeroRecords' => 'Keine Einträge vorhanden.',
                'paginate' => [
                    'first' => 'Erste',
                    'previous' => 'Zurück',
                    'next' => 'Nächste',
                    'last' => 'Letzte',
                ],
                'aria' => [
                    'sortAscending' => ' => aktivieren, um Spalte aufsteigend zu sortieren',
                    'sortDescending' => ' => aktivieren, um Spalte absteigend zu sortieren',
                ],
            ],
        ];

        view()->share('css', $this->css);
        view()->share('js', $this->js);
        view()->share('dtDefaults', json_encode($this->dtDefaults));
        view()->share('usersJson', User::lists('username')->map(function ($user) {
            $tmp['username'] = $user;
            $tmp['slug'] = str_slug($user);
            return $tmp;
        })->toJson());
    }

    public function register()
    {
        //
    }
}

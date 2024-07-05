<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Layout\Menu;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Admin::style('
    .header-navbar.navbar-with-menu div.navbar-container {
        display: block !important;
        height: 60px !important;
    }
    div.d-sm-flex {
        display: flex !important;
    }
    .table.custom-data-table.data-table tbody tr {
        cursor: unset !important;
    }


    /** top-menu-style start */
    .custombar div.content-wrapper {
        margin-left: 0 !important;
    }
    .custombar aside.main-horizontal-sidebar {
        top: 0 !important;
    }
    .custombar nav.header-navbar {
        display: none !important;
    }
    .custombar .content div.content-wrapper {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .custombar.horizontal-menu div.header-navbar.navbar-horizontal {
        top: 0 !important;
        position: relative !important;
    }
    .custombar.horizontal-menu .main-horizontal-sidebar {
        position: relative !important;
    }
    .custombar div.navbar {
        display: block !important;
    }
    /** top-menu-style end */

    .with-errors .control-label {
        text-transform: none;
    }
');

Admin::menu(function (Menu $menu) {
    $id = 1;
    $menu->add([
        [
            'id'            => $id ++,
            'title'         => 'Endpoints',
            'icon'          => 'feather icon-circle',
            'uri'           => 'endpoints',
            'parent_id'     => 0, 
        ],  
        [
            'id'            => $id ++,
            'title'         => 'Targets',
            'icon'          => 'feather icon-external-link',
            'uri'           => 'endpoints-targets',
            'parent_id'     => 0, 
        ],
    ]);
});

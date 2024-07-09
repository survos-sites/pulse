<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'twig' => [
        'version' => '1.17.1',
    ],
    'locutus/php/strings/sprintf' => [
        'version' => '2.0.16',
    ],
    'locutus/php/strings/vsprintf' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/round' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/max' => [
        'version' => '2.0.16',
    ],
    'locutus/php/math/min' => [
        'version' => '2.0.16',
    ],
    'locutus/php/strings/strip_tags' => [
        'version' => '2.0.16',
    ],
    'locutus/php/datetime/strtotime' => [
        'version' => '2.0.16',
    ],
    'locutus/php/datetime/date' => [
        'version' => '2.0.16',
    ],
    'locutus/php/var/boolval' => [
        'version' => '2.0.16',
    ],
    'axios' => [
        'version' => '1.6.7',
    ],
    'fos-routing' => [
        'version' => '0.0.6',
    ],
    'perfect-scrollbar' => [
        'version' => '1.5.5',
    ],
    'perfect-scrollbar/css/perfect-scrollbar.min.css' => [
        'version' => '1.5.5',
        'type' => 'css',
    ],
    'datatables.net-plugins/i18n/en-GB.mjs' => [
        'version' => '2.0.2',
    ],
    'datatables.net-bs5' => [
        'version' => '2.0.3',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'datatables.net' => [
        'version' => '2.0.3',
    ],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => [
        'version' => '2.0.3',
        'type' => 'css',
    ],
    'datatables.net-buttons-bs5' => [
        'version' => '3.0.1',
    ],
    'datatables.net-buttons' => [
        'version' => '3.0.1',
    ],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css' => [
        'version' => '3.0.1',
        'type' => 'css',
    ],
    'datatables.net-responsive-bs5' => [
        'version' => '3.0.1',
    ],
    'datatables.net-responsive' => [
        'version' => '3.0.1',
    ],
    'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css' => [
        'version' => '3.0.1',
        'type' => 'css',
    ],
    'datatables.net-scroller-bs5' => [
        'version' => '2.4.1',
    ],
    'datatables.net-scroller' => [
        'version' => '2.4.1',
    ],
    'datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'datatables.net-searchpanes-bs5' => [
        'version' => '2.3.0',
    ],
    'datatables.net-searchpanes' => [
        'version' => '2.3.0',
    ],
    'datatables.net-searchpanes-bs5/css/searchPanes.bootstrap5.min.css' => [
        'version' => '2.3.0',
        'type' => 'css',
    ],
    'datatables.net-searchbuilder-bs5' => [
        'version' => '1.7.0',
    ],
    'datatables.net-searchbuilder' => [
        'version' => '1.7.0',
    ],
    'datatables.net-searchbuilder-bs5/css/searchBuilder.bootstrap5.min.css' => [
        'version' => '1.7.0',
        'type' => 'css',
    ],
    'datatables.net-select-bs5' => [
        'version' => '2.0.0',
    ],
    'datatables.net-select' => [
        'version' => '2.0.0',
    ],
    'datatables.net-select-bs5/css/select.bootstrap5.min.css' => [
        'version' => '2.0.0',
        'type' => 'css',
    ],
    'htmx.org' => [
        'version' => '2.0',
    ],
    'stimulus-timeago' => [
        'version' => '4.1.0',
    ],
    'date-fns' => [
        'version' => '2.30.0',
    ],
    '@babel/runtime/helpers/esm/typeof' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/createForOfIteratorHelper' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/assertThisInitialized' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/inherits' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/createSuper' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/classCallCheck' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/createClass' => [
        'version' => '7.23.8',
    ],
    '@babel/runtime/helpers/esm/defineProperty' => [
        'version' => '7.23.8',
    ],
    'htmx.org/dist/ext/debug.js' => [
        'version' => '1.9.10',
    ],
    'htmx.org/dist/ext/client-side-templates.js' => [
        'version' => '1.9.10',
    ],
    'mustache' => [
        'version' => '4.2.0',
    ],
    '@picocss/pico' => [
        'version' => '2.0.6',
    ],
    '@picocss/pico/css/pico.min.css' => [
        'version' => '2.0.6',
        'type' => 'css',
    ],
    'dexie' => [
        'version' => '3.2.6',
    ],
    'onsenui' => [
        'version' => '2.12.8',
    ],
    'onsenui/css/onsenui.css' => [
        'version' => '2.12.8',
        'type' => 'css',
    ],
    'onsenui/css/onsen-css-components.min.css' => [
        'version' => '2.12.8',
        'type' => 'css',
    ],
    'onsenui/esm' => [
        'version' => '2.12.8',
    ],
    'onsenui/esm/ons' => [
        'version' => '2.12.8',
    ],
    'onsenui/esm/elements/ons-page' => [
        'version' => '2.12.8',
    ],
    'onsenui/esm/elements/ons-toolbar' => [
        'version' => '2.12.8',
    ],
    'onsenui/esm/elements/ons-button' => [
        'version' => '2.12.8',
    ],
    'onsenui/esm/elements/ons-navigator' => [
        'version' => '2.12.8',
    ],
    'swiper/css/bundle' => [
        'version' => '11.0.7',
    ],
    'stimulus-carousel' => [
        'version' => '5.0.1',
    ],
    'swiper/bundle' => [
        'version' => '8.4.7',
    ],
    'ssr-window' => [
        'version' => '4.0.2',
    ],
    'dom7' => [
        'version' => '4.0.6',
    ],
    'bootswatch/dist/sandstone/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'masonry' => [
        'version' => '0.0.2',
    ],
    'masonry-layout' => [
        'version' => '4.2.2',
    ],
    'outlayer' => [
        'version' => '2.1.1',
    ],
    'get-size' => [
        'version' => '2.0.3',
    ],
    'ev-emitter' => [
        'version' => '1.1.1',
    ],
    'fizzy-ui-utils' => [
        'version' => '2.0.7',
    ],
    'desandro-matches-selector' => [
        'version' => '2.0.2',
    ],
    'stimulus-use' => [
        'version' => '0.52.2',
    ],
];

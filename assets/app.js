import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// import '@picocss/pico/css/pico.min.css'
import 'swiper/css/bundle' // for stimulus-carousel
import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootswatch/dist/sandstone/bootstrap.min.css';
import 'bootstrap';



// import ons from 'onsenui/esm/ons'
// import 'onsenui/css/onsen-css-components.min.css'
// import 'onsenui/css/onsenui.css'
// window.ons = ons;

// https://pandoc.org/
// https://hypermedia.systems/
// https://jolicode.com/blog/making-a-single-page-application-with-htmx-and-symfony
// import debug from 'htmx.org/dist/ext/debug.js'
// import 'htmx.org/dist/ext/debug.js'
import htmx from 'htmx.org';
window.htmx = htmx; // not mandatory, use to access htmx in any page
// import 'mustache'
// import 'htmx.org/dist/ext/client-side-templates.js';
// htmx.logAll();

// import './db.js';
import Masonry from 'masonry-layout';
// https://getbootstrap.com/docs/5.0/examples/masonry/
var msnry = new Masonry( '.grid', {
    columnWidth: 200
    // options
});

const path = require('path');
const mix = require('laravel-mix');

const ASSETS_DIR = 'assets/';

mix.setPublicPath('.');

mix.disableNotifications();

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    'resources/js/vendors/nioapp/nioapp.min.js',

    'node_modules/simplebar/dist/simplebar.min.js',
    'node_modules/select2/dist/js/select2.full.min.js',
    'node_modules/sweetalert2/dist/sweetalert2.min.js',
    'node_modules/toastr/build/toastr.min.js',

    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/slick-carousel/slick/slick.min.js',
    'node_modules/clipboard/dist/clipboard.min.js',

    'node_modules/chart.js/dist/chart.umd.js',

    'node_modules/nouislider/distribute/nouislider.min.js',

    'node_modules/datatables.net/js/jquery.dataTables.min.js',
    'node_modules/datatables.net-responsive/js/dataTables.responsive.min.js',
    'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
    'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',

    'node_modules/dropzone/dist/min/dropzone.min.js',

    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'node_modules/jquery-timepicker/jquery.timepicker.js',

    'resources/js/vendors/knob/jquery.knob.min.js',

    'resources/js/vendors/jquery-steps/jquery.steps.min.js',

    'node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',

    'resources/js/vendors/prettify.js',
], path.join(ASSETS_DIR, 'js/bundle.js'));

mix.js('resources/js/scripts.js', path.join(ASSETS_DIR, 'js/'))
    .js('resources/js/charts/gd-default.js', path.join(ASSETS_DIR, 'js/charts/'))
    .js('resources/js/custom.js', path.join(ASSETS_DIR, 'js/'));


mix.sass('resources/scss/dashlite.scss', path.join(ASSETS_DIR, 'css/'))
    .sass('resources/scss/theme.scss', path.join(ASSETS_DIR, 'css/'))
    .sass('resources/scss/tabs.scss', path.join(ASSETS_DIR, 'css/'))
    .options({
        processCssUrls: false,
    });

if (mix.inProduction()) {
    mix.version();
}

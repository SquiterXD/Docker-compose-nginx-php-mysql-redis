const mix = require('laravel-mix');
const tailwindcss = require("tailwindcss");
const webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

    mix
    .js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .version();

    mix.copy('resources/vendor/font-awesome/fonts', 'public/fonts')
    mix.styles([
        'resources/vendor/bootstrap-sweetalert/dist/sweetalert.css',
        'resources/vendor/select2/select2.min.css',
        'resources/vendor/select2/select2-bootstrap4.min.css',
        'resources/vendor/bootstrap.min.css',
        'resources/vendor/font-awesome/css/font-awesome.css',
        'resources/vendor/colorpicker/bootstrap-colorpicker.min.css',
        'resources/vendor/datapicker/datepicker3.css',
        'resources/vendor/daterangepicker/daterangepicker-bs3.css',
        'resources/vendor/switchery/switchery.css',
        'resources/vendor/iCheck/custom.css',
        'resources/vendor/dropzone/dropzone.css',
        'resources/vendor/dataTables/datatables.min.css',
        'resources/vendor/footable/footable.core.css',
        'resources/vendor/ladda/ladda-themeless.min.css',
        'resources/vendor/chosen/bootstrap-chosen.css',
        'resources/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css',
        // 'resources/vendor/sweetalert/sweetalert.css',
        'resources/vendor/animate.css',
        'resources/vendor/style.css',
        // 'resources/vendor/custom.css',
    ], 'public/css/vendor.css', './');

    mix.styles([
        'resources/vendor/bootstrap.min.css'
    ], 'public/css/pdf.css', './');

    mix.scripts([
        'resources/vendor/bootstrap-sweetalert/dist/sweetalert.min.js',
        'resources/vendor/jquery-3.1.1.min.js',
        'resources/vendor/popper.min.js',
        'resources/vendor/bootstrap.js',
        'resources/vendor/metisMenu/jquery.metisMenu.js',
        'resources/vendor/slimscroll/jquery.slimscroll.min.js',
        'resources/vendor/dataTables/datatables.min.js',
        'resources/vendor/footable/footable.all.min.js',
        'resources/vendor/inspinia.js',
        'resources/vendor/pace.min.js',
        'resources/vendor/colorpicker/bootstrap-colorpicker.min.js',
        'resources/vendor/datapicker/bootstrap-datepicker.js',
        'resources/vendor/daterangepicker/daterangepicker.js',
        'resources/vendor/switchery/switchery.js',
        'resources/vendor/iCheck/icheck.min.js',
        'resources/vendor/dropzone/dropzone.js',
        'resources/vendor/ladda/spin.min.js',
        'resources/vendor/ladda/ladda.min.js',
        'resources/vendor/ladda/ladda.jquery.min.js',
        'resources/vendor/select2/select2.full.min.js',
        'resources/vendor/chosen/chosen.jquery.js',
        'resources/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js',
        'resources/vendor/custom.js',
        'resources/vendor/helpers.js',
        // 'resources/vendor/sweetalert.min.js',
    ], 'public/js/vendor/app.js', './');

    mix.extract([
        'jquery',
        'axios',
        'bootstrap',
        'bootstrap-select',
        'bootstrap-vue',
        'datatables.net-bs4',
        'datatables.net-autofill-bs4',
        'datatables.net-buttons-bs4',
        'datatables.net-colreorder-bs4',
        'datatables.net-fixedcolumns-bs4',
        'datatables.net-fixedheader-bs4',
        'datatables.net-keytable-bs4',
        'datatables.net-responsive-bs4',
        'datatables.net-rowgroup-bs4',
        'datatables.net-rowreorder-bs4',
        'datatables.net-scroller-bs4',
        'datatables.net-select-bs4',
        'jasny-bootstrap',
        'json-formatter-js',
        'jszip',
        'lodash',
        'moment',
        'nouislider',
        'pdfmake',
        'popper.js',
        'sweetalert2',
        'vue',
        'vuex',
    ])


    const date = new Date().toISOString().slice(0, 10);

    mix.webpackConfig({
        output: {
            filename: mix.inProduction() ? `[name].js` : `[name].js`,
            chunkFilename: mix.inProduction() ? `js/[name].${date}.[contenthash].js` : `js/[name].js`,
        },
        plugins: [
            new webpack.DefinePlugin({
                __DATE__: JSON.stringify(date),
            }),
        ],
    });
// ], 'public/js/backend/vendor.js')

    // mix.sourceMaps();

    // // MOBILE
    // mix.js('resources/js/mobile/app.js', 'public/mobile/js/app.js')
    //     // .vue()
    //     .scripts([
    //         'resources/vendor/jquery-3.1.1.min.js',
    //         'resources/vendor/popper.min.js',
    //         'resources/vendor/bootstrap.js',
    //         'resources/vendor/metisMenu/jquery.metisMenu.js',
    //         'resources/vendor/slimscroll/jquery.slimscroll.min.js',
    //         'resources/vendor/inspinia.js',
    //         'resources/vendor/pace.min.js',
    //         'resources/vendor/bootstrap-sweetalert/dist/sweetalert.min.js',
    //     ], 'public/mobile/js/vendor/app.js')
    //     .sass('resources/sass/mobile/app.scss', 'public/mobile/css')
    //     .options({
    //         processCssUrls: false,
    //         postCss: [ tailwindcss('./tailwind.config.js') ],
    //     })
    //     .copy('resources/vendor/font-awesome/fonts', 'public/mobile/fonts')
    //     .styles([
    //         'resources/vendor/bootstrap-sweetalert/dist/sweetalert.css',
    //         'resources/vendor/select2/select2.min.css',
    //         'resources/vendor/select2/select2-bootstrap4.min.css',
    //         'resources/vendor/bootstrap.min.css',
    //         'resources/vendor/font-awesome/css/font-awesome.css',
    //         'resources/vendor/colorpicker/bootstrap-colorpicker.min.css',
    //         'resources/vendor/datapicker/datepicker3.css',
    //         'resources/vendor/daterangepicker/daterangepicker-bs3.css',
    //         'resources/vendor/switchery/switchery.css',
    //         'resources/vendor/iCheck/custom.css',
    //         'resources/vendor/dropzone/dropzone.css',
    //         'resources/vendor/dataTables/datatables.min.css',
    //         'resources/vendor/footable/footable.core.css',
    //         'resources/vendor/ladda/ladda-themeless.min.css',
    //         'resources/vendor/chosen/bootstrap-chosen.css',
    //         'resources/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css',
    //         // 'resources/vendor/sweetalert/sweetalert.css',
    //         'resources/vendor/animate.css',
    //         'resources/vendor/style.css',
    //     ], 'public/mobile/css/vendor.css', './');

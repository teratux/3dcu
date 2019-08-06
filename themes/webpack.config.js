// webpack.config.js
var Encore = require('@symfony/webpack-encore');
const path = require('path');

var CopyWebpackPlugin = require('copy-webpack-plugin'); // this line tell to webpack to use the plugin

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('sylius_app', './vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/private/app.js')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
   .autoProvidejQuery()

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/static', to: 'static' }
    ]))
;

let config = Encore.getWebpackConfig();

// config.resolve.alias = {
//                 'inputmask.dependencyLib': path.join(__dirname, 'node_modules/jquery.inputmask/extra/dependencyLibs/inputmask.dependencyLib.jquery.js'),
//                 'inputmask': path.join(__dirname, 'node_modules/jquery.inputmask/dist/inputmask/inputmask.js')
//               };
module.exports = config;

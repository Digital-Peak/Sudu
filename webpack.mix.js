const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

mix.setPublicPath('public');
mix.webpackConfig({
	output: {chunkFilename: 'js/components/[name].js'},
	// Enable if you want to analyze the bundle
	// plugins: [new BundleAnalyzerPlugin({analyzerMode: 'static'})]
});

mix.copy('resources/web', 'public');
mix.copy('node_modules/@fortawesome/fontawesome-free/svgs/solid/compress.svg', 'public/icons/actions');
mix.copy('node_modules/@fortawesome/fontawesome-free/svgs/solid/expand.svg', 'public/icons/actions');
mix.copy('resources/js/sw.js', 'public/sw.js');

mix.extract();
mix.js('resources/js/app.js', 'js')
	.sass('resources/scss/app.scss', 'css')
	.vue();

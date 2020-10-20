/**
 * The module dependencies.
 */
const path = require('path');
const utils = require('./utils');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const { ProvidePlugin } = require('webpack');

/**
 * Setup the env.
 */
const { isProd, isDev } = utils.detectEnv();

/**
 * Babel loader setup
 */
const babelLoader = {
	loader: 'babel-loader',
	options: {
		cacheDirectory: isDev,
		comments: false,
		presets: [
			[
				'env',
				{
					targets: {
						browsers: ['last 3 versions']
					}
				}
			],
			'stage-2'
		]
	}
};

/**
 * Setup the plugins for different envs.
 */
const plugins = [
	new ProvidePlugin({
		$: 'jquery',
		jQuery: 'jquery',
		Popper: ['popper.js', 'default']
	})
];

if (isProd) {
	plugins.push(
		new UglifyJSPlugin()
	);
}

/**
 * Export the configuration.
 */
module.exports = {
	/**
	 * The output.
	 */
	output: {
		filename: 'bundle.js'
	},

	/**
	 * Resolve modules that can't be installed with NPM.
	 */
	resolve: {
		modules: ['node_modules'],
		alias: {
			masonry: 'masonry-layout',
			isotope: 'isotope-layout',
			'jquery-ui': 'jquery-ui-dist/jquery-ui.js'
		}
	},

	/**
	 * Resolve the dependencies that are available in the global scope.
	 */
	externals: {
		jquery: 'jQuery'
	},

	/**
	 * Setup the transformations.
	 */
	module: {
		rules: [
			// Process JS files through Babel.
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: [babelLoader]
			}
		],
		noParse: [/raty-js/]
	},

	/**
	 * Setup the transformations.
	 */
	plugins,

	/**
	 * Setup the development tools.
	 */
	cache: isDev,
	bail: false,
	watch: isDev,
	devtool: isDev ? 'source-map' : false
};

/**
 * The module dependencies.
 */
const fs = require('fs');
const url = require('url');
const path = require('path');
const utils = require('./utils');
const argv = require('yargs').argv;

/**
 * Prepare the configuration.
 */
const config = {
	host: 'gkeranov.com',
	port: 3000,
	open: 'external',
	files: [
		utils.buildPath('**/*.css'),
		utils.buildPath('**/*.js'),
		utils.buildPath('./templates/*.php'),
		utils.buildPath('./fragments/*.php'),
		utils.buildPath('./*.php')
	],
	ghostMode: {
		clicks: false,
		scroll: true,
		forms: {
			submit: true,
			inputs: true,
			toggles: true
		}
	},
	snippetOptions: {
		rule: {
			match: /<\/body>/i,
			fn: (snippet, match) => `${snippet}${match}`
		}
	},
	proxy: 'gkeranov.com',
	reloadThrottle: 100
};

/**
 * Load the proxy configuration from cli arguments
 */
if (argv.devUrl !== undefined) {
	config.host = url.parse(argv.devUrl).hostname
	config.proxy = argv.devUrl;
}

module.exports = config;

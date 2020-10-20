/**
 * The module dependencies.
 */
const path = require('path');

module.exports.themeRootPath = (basePath = '', destPath = '') =>
	path.resolve(__dirname, '../', basePath, destPath);

module.exports.srcPath = (basePath = '', destPath = '') =>
	path.resolve(__dirname, '../', basePath, destPath);

module.exports.buildPath = (basePath = '', destPath = '') =>
	path.resolve(__dirname, '../../dist', basePath, destPath);

module.exports.srcScriptsPath = destPath =>
	exports.srcPath('js', destPath);

module.exports.srcStylesPath = destPath =>
	exports.srcPath('css', destPath);

module.exports.srcImagesPath = destPath =>
	exports.srcPath('images', destPath);

module.exports.srcFontsPath = destPath =>
	exports.srcPath('fonts', destPath);

module.exports.buildScriptsPath = destPath =>
	exports.buildPath('js', destPath);

module.exports.buildStylesPath = destPath =>
	exports.buildPath('css', destPath);

module.exports.buildImagesPath = destPath =>
	exports.buildPath('images', destPath);

module.exports.buildFontsPath = destPath =>
	exports.buildPath('fonts', destPath);

module.exports.detectEnv = () => {
	const env = process.env.NODE_ENV || 'development';
	const isDev = env === 'development';
	const isProd = env === 'production';
	const isBuild = env === 'build';

	return {
		env,
		isDev,
		isProd,
		isBuild
	};
};

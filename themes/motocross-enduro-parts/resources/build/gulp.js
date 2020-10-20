/**
 * The module dependencies.
 */
const del = require('del');
const gulp = require('gulp');
const utils = require('./utils');
const gulpif = require('gulp-if');
const rename = require('gulp-rename');
const notify = require('gulp-notify');
const postcss = require('gulp-postcss');
const plumber = require('gulp-plumber');
const webpack = require('webpack-stream');
const bundler = require('webpack');
const imagemin = require('gulp-imagemin');
const imageminMozjpeg = require('imagemin-mozjpeg');
const imageminPNGquant = require('imagemin-pngquant');
const sourcemaps = require('gulp-sourcemaps');
const rev = require('gulp-rev');
const vinyl = require('vinyl-paths');
const browserSync = require('browser-sync');

/**
 * Setup the env.
 */
const { isProd, isDev } = utils.detectEnv();

/**
 * Show notification on error.
 */
const error = function(e) {
	notify.onError({
		title: 'Gulp',
		message: e.message,
		sound: 'Beep'
	})(e);

	this.emit('end');
};

/**
 * Process CSS files through PostCSS.
 */
const styles = () => {
	const src = utils.srcStylesPath('_load.css');
	const dest = utils.buildStylesPath();
	const config = require('./postcss');

	return gulp
		.src(src)
		.pipe(gulpif(isDev, sourcemaps.init()))
		.pipe(gulpif(isDev, plumber({ errorHandler: error })))
		.pipe(postcss(config))
		.pipe(rename('bundle.css'))
		.pipe(gulpif(isDev, sourcemaps.write('./')))
		.pipe(gulp.dest(dest));
};

/**
 * Process JS files through Webpack.
 */
const scripts = () => {
	const src = utils.srcScriptsPath('main.js');
	const dest = utils.buildScriptsPath();
	const config = require('./webpack');

	return gulp
		.src(src)
		.pipe(plumber({ errorHandler: error }))
		.pipe(webpack(config, bundler))
		.pipe(gulp.dest(dest));
};

/**
 * Copy all images used in HTML files.
 */
const images = () => {
	const src = [
		utils.srcImagesPath('**/*'),
		`!${utils.srcImagesPath('sprite*')}`,
		`!${utils.srcImagesPath('sprite/*')}`
	];
	const dest = utils.buildImagesPath();

	return gulp
		.src(src)
		.pipe(plumber({ errorHandler: error }))
		.pipe(gulp.dest(dest));
};

/**
 * Optimize all images in the build folder.
 */
const optimize = () => {
	const src = utils.buildImagesPath('**/*');
	const dest = utils.buildImagesPath();

	return gulp
		.src(src)
		.pipe(plumber({ errorHandler: error }))
		.pipe(
			imagemin([
				// GIFs
				// https://github.com/imagemin/imagemin-gifsicle#api
				imagemin.gifsicle({
					interlaced: true
				}),

				// JP(E)G
				// https://github.com/imagemin/imagemin-jpegtran#api
				imageminMozjpeg({
					quality: 70
				}),

				// PNG
				// https://github.com/imagemin/imagemin-optipng#api
				imageminPNGquant({
					speed: 1,
					quality: 90
				}),

				// SVG
				// https://github.com/imagemin/imagemin-svgo#api
				// https://github.com/svg/svgo#what-it-can-do
				imagemin.svgo({
					plugins: [
						{ cleanupAttrs: true },
						{ removeDoctype: true },
						{ removeXMLProcInst: true },
						{ removeComments: true },
						{ removeMetadata: true },
						{ removeUselessDefs: true },
						{ removeEditorsNSData: true },
						{ removeEmptyAttrs: true },
						{ removeHiddenElems: false },
						{ removeEmptyText: true },
						{ removeEmptyContainers: true },
						{ cleanupEnableBackground: true },
						{ removeViewBox: true },
						{ cleanupIDs: false },
						{ convertStyleToAttrs: true }
					]
				})
			])
		)
		.pipe(gulp.dest(dest));
};

/**
 * Generate a production-ready manifest file.
 */
const manifest = () => {
	const base = utils.buildPath();
	const src = [
		utils.buildStylesPath('bundle.css'),
		utils.buildScriptsPath('bundle.js')
	];

	return gulp
		.src(src, { base })
		.pipe(vinyl(paths => del(paths, { force: true })))
		.pipe(rev())
		.pipe(gulp.dest(base))
		.pipe(rev.manifest('manifest.json'))
		.pipe(gulp.dest(base));
};

/**
 * Watch for changes and run through different tasks.
 */
const watch = () => {
	gulp.watch(
		[utils.srcStylesPath('*.css'), utils.srcImagesPath('sprite/*.png')],
		styles
	);

	gulp.watch([utils.srcImagesPath('**/*')], images);
};

/**
 * Refresh the browser when a file is changed.
 */
const reload = () => {
	const config = require('./browsersync');

	browserSync(config);
};

/**
 * Remove the build.
 */
const clean = () => {
	return del([utils.buildPath()], { force: true });
};

/**
 * Register the tasks.
 */
gulp.task(
	'dev',
	gulp.series(clean, gulp.parallel(styles, scripts, images, watch, reload))
);

gulp.task('build', gulp.series(clean, styles, scripts, images, optimize, manifest));

/**
 * Register default gulp task.
 */
gulp.task('default', gulp.parallel('dev'));

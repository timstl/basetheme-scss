const proxy_url = '127.0.0.1:8080/basetheme';

const gulp = require( 'gulp' );
const sass = require( 'gulp-sass' );
const postcss = require( 'gulp-postcss' );
const autoprefixer = require( 'autoprefixer' );
const cssnano = require( 'cssnano' );
const sourcemaps = require( 'gulp-sourcemaps' );
const uglify = require( 'gulp-uglify' );
const babel = require( 'gulp-babel' );
const eslint = require( 'gulp-eslint' );
const concat = require( 'gulp-concat' );
const mergeStream = require( 'merge-stream' );
const browserSync = require( 'browser-sync' ).create();

const paths = {
	styles: {
		src: [ './src/scss/*.scss', '!./src/scss/blocks/standalone/*.scss' ],
		dest: './dist/css/'
	},
	js: {
		head: {
			src: {
				vendor: [
					'./src/js/head/vendor/**/*.js',
					'./src/js/head/bootstrap/**/*.js'
				],
				custom: [ './src/js/head/custom/**/*.js' ]
			},
			dest: './dist/js'
		},
		footer: {
			src: {
				vendor: [
					'./src/js/footer/vendor/**/*.js',
					'./src/js/footer/bootstrap/**/*.js'
				],
				custom: [ './src/js/footer/custom/**/*.js' ]
			},
			dest: './dist/js'
		}
	}
};

function style() {
	return (
		gulp
			.src( paths.styles.src )

			// Initialize sourcemaps before compilation starts
			.pipe( sourcemaps.init() )
			.pipe( sass() )
			.on( 'error', sass.logError )

			// Use postcss with autoprefixer and compress the compiled file using cssnano
			.pipe( postcss([ autoprefixer(), cssnano() ]) )

			// Now add/write the sourcemaps
			.pipe( sourcemaps.write( './' ) )
			.pipe( gulp.dest( paths.styles.dest ) )

			// Add browsersync stream pipe after compilation
			.pipe( browserSync.stream() )
	);
}

function doJS( scripts_nobabel, scripts_babel, scripts_dest, filename ) {
	var streams = [];

	scripts_nobabel.forEach( function( path ) {
		streams.push( gulp.src( path ).pipe( uglify() ) );
	});

	scripts_babel.forEach( function( path ) {
		streams.push(
			gulp
				.src( path )
				.pipe( eslint() )
				.pipe( eslint.format() )
				.pipe( eslint.failAfterError() )
				.pipe( babel({ presets: [ '@babel/preset-env' ] }) )
				.pipe( uglify() )
		);
	});

	return mergeStream( streams )
		.pipe( concat( filename ) )
		.pipe( gulp.dest( scripts_dest ) )
		.pipe( browserSync.stream() );
}

function scriptshead() {
	return doJS(
		paths.js.head.src.vendor,
		paths.js.head.src.custom,
		paths.js.head.dest,
		'head.min.js'
	);
}

function scriptsfooter() {
	return doJS(
		paths.js.footer.src.vendor,
		paths.js.footer.src.custom,
		paths.js.footer.dest,
		'scripts.min.js'
	);
}

// Add browsersync initialization at the start of the watch task
function watch() {
	browserSync.init([ '**/*.php', 'img/**/*.{png,jpg,gif}' ], {

		// If you are already serving your website locally using something like apache
		// You can use the proxy setting to proxy that instead
		proxy: proxy_url
	});

	gulp.watch( paths.styles.src, style );
	gulp.watch( paths.js.head.src.vendor, scriptshead );
	gulp.watch( paths.js.head.src.custom, scriptshead );
	gulp.watch( paths.js.footer.src.vendor, scriptsfooter );
	gulp.watch( paths.js.footer.src.custom, scriptsfooter );
}

// We don't have to expose the reload function
// It's currently only useful in other functions

// Don't forget to expose the task!
exports.watch = watch;

// Expose the task by exporting it
// This allows you to run it from the commandline using
// $ gulp style
exports.style = style;
exports.scriptshead = scriptshead;
exports.scriptsfooter = scriptsfooter;

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 */
var build = gulp.parallel( watch );

/*
 * You can still use `gulp.task` to expose tasks
 */
//gulp.task('build', build);

/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task( 'default', build );

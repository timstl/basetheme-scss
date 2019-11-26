/**
 * Browser Sync proxy URL.
 * Update this URL to point to your local environment URL.
 */
const proxy_url = '127.0.0.1:8080/basetheme';

/**
 * Require
 */
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
const through2 = require( 'through2' );
const browserSync = require( 'browser-sync' ).create();

const fs = require( 'fs' );
const del = require( 'del' );

/**
 * Directories that we'll watch and/or process
 */
const paths = {
	styles: {
		src: [
			'./src/scss/**/*.scss',
			'!./src/scss/blocks/enqueue_style/**/*.scss'
		],
		dest: './dist/css/',
		blocks: {
			src: [ './src/scss/blocks/enqueue_style/**/*.scss' ],
			dest: './dist/css/blocks/'
		}
	},
	js: {
		blocks: {
			dir: './src/js/blocks/',
			src: [ './src/js/blocks/' ],
			dest: './dist/js/blocks'
		},
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

/**
 * SCSS
 */
function style() {
	return do_styles( paths.styles.src, paths.styles.dest );
}
function blockStyle() {
	return do_styles( paths.styles.blocks.src, paths.styles.blocks.dest );
}

function do_styles( src, dest ) {
	return (
		gulp
			.src( src )

			// Initialize sourcemaps before compilation starts
			.pipe( sourcemaps.init() )
			.pipe( sass() )
			.on( 'error', sass.logError )

			// Use postcss with autoprefixer and compress the compiled file using cssnano
			.pipe( postcss([ autoprefixer(), cssnano() ]) )

			// Now add/write the sourcemaps
			.pipe( sourcemaps.write( './' ) )
			.pipe(
				through2.obj( function( file, enc, cb ) {
					var date = new Date();
					file.stat.atime = date;
					file.stat.mtime = date;
					cb( null, file );
				})
			)
			.pipe( gulp.dest( dest ) )

			// Add browsersync stream pipe after compilation
			.pipe( browserSync.stream() )
	);
}

/**
 * Javascript
 */
function doJS( scripts_nobabel, scripts_babel, scripts_dest, filename ) {
	var streams = [];

	/**
	 * Don't put vendor scripts through babel.
	 */
	scripts_nobabel.forEach( function( path ) {
		streams.push( gulp.src( path ).pipe( uglify() ) );
	});

	/**
	 * Process custom scripts through eslint, babel, and uglify.
	 */
	scripts_babel.forEach( function( path ) {
		streams.push(
			gulp
				.src( path )
				.pipe( eslint() )
				.pipe( eslint.format() )

				//.pipe( eslint.failAfterError() )
				.pipe( babel({ presets: [ '@babel/preset-env' ] }) )
				.pipe( uglify() )
		);
	});

	/**
	 * Merge everything into a single destination.
	 */
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

function scriptsblocks() {
	var streams = [];
	const dir = paths.js.blocks.dir;

	/**
	 * Delete all javascript in the /dist/js/blocks/ folder.
	 * If we don't do this, sometimes old block scripts will remain.
	 */
	del([ paths.js.blocks.dest + '/**' ]);

	files = fs.readdirSync( dir );
	files.forEach( file => {

		/**
		 * Loop through each block javascript directory.
		 */
		if ( fs.lstatSync( dir + file ).isDirectory() ) {
			const block_dir = dir + file;
			var block_stream = [];

			if ( fs.existsSync( block_dir + '/vendor/' ) ) {

				/**
				 * Add the vendor scripts for this block first.
				 */
				block_stream.push(
					gulp.src( block_dir + '/vendor/**/*.js' ).pipe( uglify() )
				);
			}

			/**
			 * Now add the remaining javascript files.
			 * Run those through babel and uglify.
			 */
			block_stream.push(
				gulp
					.src([
						block_dir + '/**/*.js',
						'!' + block_dir + '/vendor/**/*.js'
					])
					.pipe( eslint() )
					.pipe( eslint.format() )

					//.pipe( eslint.failAfterError() )
					.pipe( babel({ presets: [ '@babel/preset-env' ] }) )
					.pipe( uglify() )
			);

			/**
			 * Concat everything into a single block-{name}.min.js file.
			 */
			streams.push(
				mergeStream( block_stream ).pipe(
					concat( 'block-' + file + '.min.js' )
				)
			);
		}
	});

	if ( 0 < streams.length ) {

		/**
		 * Merge all streams and pipe to the /dist/ folder.
		 */
		return mergeStream( streams ).pipe( gulp.dest( paths.js.blocks.dest ) );
	}

	return gulp.src( dir );
}

/**
 * Watch
 */
function watch() {

	/**
	 * BrowserSync.
	 * Watch for changes to PHP or image files.
	 */
	browserSync.init([ '**/*.php', 'img/**/*.{png,jpg,gif}' ], {
		proxy: proxy_url,
		open: false
	});

	/**
	 * Watch various src folders and run appropriate functions.
	 */
	gulp.watch( paths.styles.src, style );
	gulp.watch( paths.styles.blocks.src, blockStyle );
	gulp.watch( paths.js.head.src.vendor, scriptshead );
	gulp.watch( paths.js.head.src.custom, scriptshead );
	gulp.watch( paths.js.footer.src.vendor, scriptsfooter );
	gulp.watch( paths.js.footer.src.custom, scriptsfooter );
	gulp.watch( paths.js.blocks.src, scriptsblocks );
}

/**
 * Export
 */
exports.watch = watch;

/**
 * Expose the task by exporting it
 * This allows you to run it from the commandline using
 * $ gulp style
 */
exports.style = style;
exports.blockStyle = blockStyle;
exports.scriptsblocks = scriptsblocks;
exports.scriptshead = scriptshead;
exports.scriptsfooter = scriptsfooter;

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 */
const build = gulp.parallel( watch );

/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task( 'default', build );

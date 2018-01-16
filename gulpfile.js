"use strict";
var URL = 'http://127.0.0.1:8080/basetheme';

var $ = require('gulp-load-plugins')(),
	gulp = require('gulp'),
	sass = require('gulp-sass'),
	maps = require('gulp-sourcemaps'),
	gutil = require('gulp-util'),
	notify = require('gulp-notify'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	cleanCSS    = require('gulp-clean-css'),
	babel = require('gulp-babel'),
	browserSync = require('browser-sync').create();

/* For autoprefixer */
var COMPATIBILITY = [
	'last 2 versions',
	'ie >= 10'
];

function handleErrors() {
	gutil.beep();
  var args = Array.prototype.slice.call(arguments);
  notify.onError({
	title: 'Compile Error',
	message: '<%= error.message %>'
  }).apply(this, args);
  this.emit('end'); // Keep gulp from hanging on this task
}	

// Browsersync task
gulp.task('browser-sync', function() {

	var files = [
						'**/*.php',
						'img/**/*.{png,jpg,gif}',
					];

	browserSync.init(files, {
		// Proxy address
		proxy: URL,

		// Port #
		//port: PORT
	});
});

gulp.task("compileSass", function(){
	return gulp.src("scss/*.scss")
		.pipe(maps.init())
		.pipe(sass())
		.on('error', handleErrors)
		.pipe($.autoprefixer({
			browsers: COMPATIBILITY
		}))
		.pipe(cleanCSS())
		.pipe(maps.write('./'))
		.pipe(gulp.dest('dist'))
		.pipe(browserSync.stream());
});

gulp.task('lint', function() {
	return gulp.src('js/footer/custom/*.js')
		.pipe($.jshint({esversion: 6}))
		.pipe($.notify(function (file) {
			if (file.jshint.success) {
				return false;
			}

			var errors = file.jshint.results.map(function (data) {
				if (data.error) {
					return "(" + data.error.line + ':' + data.error.character + ') ' + data.error.reason;
				}
			}).join("\n");
			return file.relative + " (" + file.jshint.results.length + " errors)\n" + errors;
		}));
});

gulp.task('scriptshead', function() {
	return gulp.src(['./js/head/vendor/*.js', './js/head/vendor/**/*.js', './js/head/bootstrap/*.js', './js/head/custom/*.js', '!./js/head/vendor/jquery.min.js'])
	.pipe(concat('head.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./dist/'))
	.pipe(browserSync.stream());
});

gulp.task('pluginsfooter', function() {
	return gulp.src(['./js/footer/bootstrap/*.js', './js/footer/vendor/*.js', './js/footer/vendor/**/*.js'])
	.pipe(concat('plugins.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./dist/'))
	.pipe(browserSync.stream());
});

gulp.task('scriptsfooter', function() {
	return gulp.src(['./js/footer/custom/*.js', './js/footer/custom/**/*.js'])
	.pipe(babel({ presets: ['env'] }))
	.pipe(concat('scripts.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./dist/'))
	.pipe(browserSync.stream());
});

gulp.task("watchFiles", function() {
	gulp.watch('scss/**/*.scss', ['compileSass']);
	gulp.watch('js/head/**/*.js', ['scriptshead']);
	gulp.watch('js/footer/**/*.js', ['pluginsfooter']);
	gulp.watch('js/footer/custom/*.js', ['scriptsfooter']);
	gulp.watch('js/footer/custom/*.js', ['lint']);
});

gulp.task("default", function() {
	gulp.start('browser-sync');
	gulp.start('watchFiles');
});
"use strict";

var $ = require('gulp-load-plugins')(),
	gulp = require('gulp'),
	sass = require('gulp-sass'),
	maps = require('gulp-sourcemaps'),
	gutil = require('gulp-util'),
	notify = require('gulp-notify'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	cleanCSS    = require('gulp-clean-css');

var COMPATIBILITY = [
	'last 2 versions',
	'ie >= 9',
	'Android >= 2.3'
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
	
gulp.task("compileSass", function(){
	return gulp.src("scss/**/*.scss")
		.pipe(maps.init())
		.pipe(sass())
		.on('error', handleErrors)
		.pipe($.autoprefixer({
			browsers: COMPATIBILITY
		}))
		.pipe(cleanCSS())
		.pipe(maps.write('./'))
		.pipe(gulp.dest('dist'));
});

gulp.task('lint', function() {
	return gulp.src('js/footer/custom/*.js')
		.pipe($.jshint())
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
	return gulp.src(['./js/head/**/*.js', '!js/**/jquery.min.js'])
	.pipe(concat('head.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./dist/'));
});

gulp.task('scriptsfooter', function() {
  return gulp.src(['./js/footer/**/*.js', '!js/**/jquery.min.js'])
	.pipe(concat('footer.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./dist/'));
});

gulp.task("watchFiles", function() {
	gulp.watch('scss/**/*.scss', ['compileSass']);
	gulp.watch('js/head/**/*.js', ['scriptshead']);
	gulp.watch('js/footer/**/*.js', ['scriptsfooter']);
	gulp.watch('js/footer/custom*/*.js', ['lint']);
});

gulp.task("default", function() {
	gulp.start('watchFiles');
});
"use strict";

var gulp = require('gulp'),
	sass = require('gulp-sass'),
	maps = require('gulp-sourcemaps'),
	gutil = require('gulp-util'),
	notify = require('gulp-notify');

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
		.pipe(maps.write('./'))
		.pipe(gulp.dest('css'));
});

gulp.task("watchFiles", function() {
	gulp.watch('scss/**/*.scss', ['compileSass']);
});

gulp.task("default", function() {
	gulp.start('watchFiles');
});
"use strict";
var URL = "http://127.0.0.1:8080/basetheme";

var $ = require("gulp-load-plugins")(),
	gulp = require("gulp"),
	sass = require("gulp-sass"),
	maps = require("gulp-sourcemaps"),
	gutil = require("gulp-util"),
	notify = require("gulp-notify"),
	concat = require("gulp-concat"),
	uglify = require("gulp-uglify"),
	cleanCSS = require("gulp-clean-css"),
	squeue = require("streamqueue"),
	babel = require("gulp-babel"),
	browserSync = require("browser-sync").create();

/* For autoprefixer */
var COMPATIBILITY = ["last 2 versions", "ie >= 10", "Android >= 2.3"];

function handleErrors() {
	gutil.beep();
	var args = Array.prototype.slice.call(arguments);
	notify
		.onError({
			title: "Compile Error",
			message: "<%= error.message %>"
		})
		.apply(this, args);
	this.emit("end"); // Keep gulp from hanging on this task
}

function bsync() {
	var files = ["**/*.php", "img/**/*.{png,jpg,gif}"];

	browserSync.init(files, {
		// Proxy address
		proxy: URL

		// Port #
		//port: PORT
	});
}

function compileSass() {
	return gulp
		.src("scss/*.scss")
		.pipe(maps.init())
		.pipe(sass())
		.on("error", handleErrors)
		.pipe(
			$.autoprefixer({
				browsers: COMPATIBILITY
			})
		)
		.pipe(cleanCSS())
		.pipe(maps.write("./"))
		.pipe(gulp.dest("dist"))
		.pipe(browserSync.stream());
}

function lintjs() {
	return gulp
		.src("js/footer/custom/*.js")
		.pipe($.jshint({ esversion: 6 }))
		.pipe(
			$.notify(function(file) {
				if (file.jshint.success) {
					return false;
				}

				var errors = file.jshint.results
					.map(function(data) {
						if (data.error) {
							return (
								"(" +
								data.error.line +
								":" +
								data.error.character +
								") " +
								data.error.reason
							);
						}
					})
					.join("\n");
				return (
					file.relative +
					" (" +
					file.jshint.results.length +
					" errors)\n" +
					errors
				);
			})
		);
}

function scriptshead() {
	return squeue(
		{ objectMode: true },
		gulp
			.src([
				"./js/head/vendor/**/*.js",
				"!./js/head/vendor/jquery.min.js"
			])
			.pipe(uglify()),
		gulp.src(["./js/head/bootstrap/**/*.js"]).pipe(uglify()),
		gulp
			.src(["./js/head/custom/**/*.js"])
			.pipe(babel({ presets: ["@babel/preset-env"] }))
			.pipe(uglify())
	)
		.pipe(concat("head.min.js"))
		.pipe(gulp.dest("./dist/"))
		.pipe(browserSync.stream());
}

function scriptsfooter() {
	return squeue(
		{ objectMode: true },
		gulp.src(["./js/footer/vendor/**/*.js"]).pipe(uglify()),
		gulp.src(["./js/footer/bootstrap/**/*.js"]).pipe(uglify()),
		gulp
			.src(["./js/footer/custom/**/*.js"])
			.pipe(babel({ presets: ["@babel/preset-env"] }))
			.pipe(uglify())
	)
		.pipe(concat("scripts.min.js"))
		.pipe(gulp.dest("./dist/"))
		.pipe(browserSync.stream());
}

function watchFiles() {
	gulp.watch("scss/**/*.scss", compileSass);
	gulp.watch("js/head/**/*.js", scriptshead);
	gulp.watch("js/footer/**/*.js", scriptsfooter);
	gulp.watch("js/head/custom/**/*.js", lintjs);
	gulp.watch("js/footer/custom/**/*.js", lintjs);
}

exports.default = gulp.parallel(watchFiles, bsync);

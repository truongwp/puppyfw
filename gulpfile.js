var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var gutil = require('gulp-util');
// var browserSync = require('browser-sync').create();

var input = ['assets/sass/*.scss', 'assets/sass/**/*.scss'];

var output = 'assets/css';

var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};

var autoprefixerOptions = {
	browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};


// Compile sass
gulp.task('sass', function () {
	gulp
		// Find all `.sass` files from the `stylesheets/` folder
		.src(input)

		.pipe(sourcemaps.init())

		// Run Sass on those files
		.pipe(sass(sassOptions).on('error', sass.logError))

		.pipe(autoprefixer(autoprefixerOptions))

		.pipe(sourcemaps.write('../sourcemaps'))

		// Write the resulting CSS in the output folder
		.pipe(gulp.dest(output))

		/*.pipe(browserSync.stream())*/;
});


// Minify css
gulp.task('minify-css', function() {
	gulp
		.src([
			'assets/**/*.css',
			'!assets/**/*.min.css'
		])

		.pipe(cleanCSS({compatibility: 'ie8'}))

		.pipe(rename({suffix: '.min'}))

		.pipe(gulp.dest('assets/'));
});


// Minify js
gulp.task('minify-js', function() {
	gulp
		.src([
			'assets/**/*.js',
			'!assets/**/*.min.js'
		])

		.pipe(uglify().on('error', gutil.log))

		.pipe(rename({suffix: '.min'}))

		.pipe(gulp.dest('assets/'));
});


gulp.task('watch', function() {
	gulp
		// Watch the input folder for change,
		// and run `sass` task when something happens
		.watch(input, ['sass'])
		// When there is a change,
		// log a message in the console
		.on('change', function(event) {
			console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
		});

	// gulp.watch(['assets/**/*.css', '!assets/**/*.min.css'], ['minify-css']);
    //
	// gulp.watch(['assets/**/*.js', '!assets/**/*.min.js'], ['minify-js']);
});


gulp.task('default', ['sass', 'watch']);

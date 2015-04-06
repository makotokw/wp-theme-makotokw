/*jshint node: true */
'use strict';

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var reload = browserSync.reload;

gulp.task('clean', function (cb) {
	var del = require('del');
	del(['components'], cb);
});

gulp.task('makepot', plugins.shell.task([
	'xgettext --from-code=UTF-8 -k__ -k_e -L PHP -o ./languages/messages.pot ./*.php ./*/*.php --package-name=makotokw --package-version=1.0 --msgid-bugs-address=makoto.kw@gmail.com',
	'msgmerge --update ./languages/ja.po ./languages/messages.pot --backup=off'
]));

gulp.task('make-languages-po', plugins.shell.task([
	'msgfmt -o ./languages/ja.mo ./languages/ja.po'
]));

gulp.task('violations', ['phpcs', 'jshint']);

gulp.task('phpcs', plugins.shell.task(
	['phpcs --report-width=1024 --standard=build/phpcs.xml *.php ./**/*.php'],
	{ignoreErrors: true}
));

gulp.task('jshint', function () {
	return gulp.src(['gulpfile.js', 'js/*.js'])
		.pipe(plugins.jshint())
		.pipe(plugins.jshint.reporter('jshint-stylish'))
		.pipe(plugins.if(!browserSync.active, plugins.jshint.reporter('fail')));
});

gulp.task('jscompress', function () {
	gulp.src([
		'components/google-code-prettify/js/prettify.js',
		'js/skip-link-focus-fix.js',
		'js/script.js'
	])
		.pipe(plugins.plumber())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.concat('style.js'))
		.pipe(plugins.uglify({output: {'beautify': true}}))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('.'))
		.pipe(reload({stream: true, once: true}));
});

gulp.task('sass', function () {
	gulp.src('sass/*.scss')
		.pipe(plugins.plumber())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({indentedSyntax: false}))
		.pipe(plugins.pleeease({
			autoprefixer: {
				browsers: ['last 2 versions']
			},
			minifier: false
		}))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('.'))
		.pipe(reload({stream: true, once: true}));
});

gulp.task('browser-sync', function () {
	browserSync({
		port: 8086,
		proxy: "localhost:8085"
	});
});

gulp.task('bs-reload', function () {
	browserSync.reload();
});

gulp.task('bower', function () {
	var bower = require('main-bower-files');
	return gulp.src(bower(), {base: './bower_components'})
		.pipe(plugins.bowerNormalize({bowerJson: './bower.json'}))
		.pipe(gulp.dest('./components/'));
});

gulp.task('default',
	[
		'jscompress',
		'sass',
		'browser-sync'
	],
	function () {
		gulp.watch("js/*.js", ['jshint', 'jscompress']);
		gulp.watch("sass/**/*.scss", ['sass']);
		gulp.watch("**/*.php", ['phpcs', 'bs-reload']);
	}
);

gulp.task('build', [
	'clean',
	'bower',
	'sass'
], function () {
});
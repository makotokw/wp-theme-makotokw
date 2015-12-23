/*jshint node: true */
'use strict';

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var reload = browserSync.reload;
var del = require('del');

gulp.task('clean:components', function () {
	return del(['components']);
});
gulp.task('bower:install', plugins.shell.task(['bower install']));
gulp.task('bower:normalize', ['clean:components', 'bower:install'], function () {
	var mainBowerFiles = require('main-bower-files');
	var bowerNormalizer = require('gulp-bower-normalize');
	gulp.src(mainBowerFiles(), {base: './bower_components'})
		.pipe(bowerNormalizer({bowerJson: './bower.json'}))
		.pipe(gulp.dest('./components/'));
});

gulp.task('violations', ['phpcs', 'jshint']);

gulp.task('phpcs', plugins.shell.task(
	'phpcs --report-width=1024 --standard=build/phpcs.xml *.php ./**/*.php',
	{ignoreErrors: true}
));

gulp.task('jshint', function () {
	return gulp.src(['gulpfile.js', 'js/*.js'])
		.pipe(plugins.jshint())
		.pipe(plugins.jshint.reporter('jshint-stylish'))
		.pipe(plugins.if(!browserSync.active, plugins.jshint.reporter('fail')));
});

gulp.task('makepot', plugins.shell.task([
	'xgettext --from-code=UTF-8 -k__ -k_e -L PHP -o ./languages/messages.pot ./*.php ./*/*.php --package-name=makotokw --package-version=1.0 --msgid-bugs-address=makoto.kw@gmail.com',
	'msgmerge --update ./languages/ja.po ./languages/messages.pot --backup=off'
]));

gulp.task('make-languages-po', plugins.shell.task([
	'msgfmt -o ./languages/ja.mo ./languages/ja.po'
]));

gulp.task('clean:map', function (cb) {
	del(['*.map'], function (err, deletedFiles) {
		if (deletedFiles.length > 0) {
			plugins.util.log('Files deleted:', deletedFiles.join(', '));
		}
		cb();
	});
});

function js(env) {
	gulp.src([
		'components/modernizr/js/modernizr.js',
		'components/google-code-prettify/js/prettify.js',
		'js/script.js'
	])
		.pipe(plugins.plumber())
		.pipe(plugins.if(env == 'development', plugins.sourcemaps.init()))
		.pipe(plugins.concat('style.js'))
		.pipe(plugins.uglify({output: {beautify: true}}))
		.pipe(plugins.if(env == 'development', plugins.sourcemaps.write('.')))
		.pipe(gulp.dest('.'))
		.pipe(reload({stream: true, once: true}));
}

gulp.task('js:dev', function () {
	js('development');
});

gulp.task('js', function () {
	js('production');
});

function sass(env) {
	var isDebug = env == 'development';
	return plugins.rubySass('./sass/', {
		verbose: isDebug,
		loadPath: ['components'],
		lineNumbers: isDebug
	})
		.pipe(plugins.plumber())
		.pipe(plugins.autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('.'))
		.pipe(reload({stream: true, once: true}));
}

gulp.task('sass:dev', function () {
	sass('development');
});

gulp.task('sass', function () {
	sass('production');
});

gulp.task('browser-sync', function () {
	browserSync({
		port: 8086,
		proxy: "127.0.0.1:8085"
	});
});

gulp.task('bs-reload', function () {
	browserSync.reload();
});

gulp.task('default', ['js:dev', 'sass:dev', 'browser-sync'],
	function () {
		gulp.watch('js/*.js', ['jshint', 'js:dev']);
		gulp.watch('sass/**/*.scss', ['sass:dev']);
		gulp.watch('**/*.php', ['phpcs', 'bs-reload']);
		gulp.watch('languages/*.mo', ['bs-reload']);
	}
);

gulp.task('build', ['js', 'sass', 'clean:map']);

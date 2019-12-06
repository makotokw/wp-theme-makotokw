'use strict';

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var reload = browserSync.reload;

var wpRoot = '../../../';

gulp.task('phpcs', plugins.shell.task(
  'phpcs --colors -s --report-width=1024 --standard=phpcs.xml *.php ./**/*.php',
  {ignoreErrors: true}
));

gulp.task('checkstyle', gulp.series('phpcs'));

gulp.task('webpack:dev', plugins.shell.task([
  'webpack --config webpack.config.js --mode development',
]));

gulp.task('make-languages-pot-1st', plugins.shell.task([
  'xgettext --from-code=UTF-8 -k__ -k_e -L PHP -o ./languages/messages.pot ./*.php ./*/*.php --package-name=makotokw --package-version=1.0 --msgid-bugs-address=makoto.kw@gmail.com',
  'msgmerge --update ./languages/ja.po ./languages/messages.pot --backup=off'
]));

gulp.task('make-languages-mo-2nd', plugins.shell.task([
  'msgfmt -o ./languages/ja.mo ./languages/ja.po'
]));

function js(env) {
  gulp.src([
    'components/google-code-prettify/js/prettify.js',
    'js/vendor/*/*.js',
    'js/main.js'
  ])
    .pipe(plugins.plumber())
    .pipe(plugins.if(env === 'development', plugins.sourcemaps.init()))
    .pipe(plugins.concat('style.js'))
    .pipe(plugins.uglify({output: {beautify: true}}))
    .pipe(plugins.if(env === 'development', plugins.sourcemaps.write('.')))
    .pipe(gulp.dest('.'))
    .pipe(reload({stream: true, once: true}));
}

gulp.task('browser-sync', function () {
  plugins.connectPhp.server({
    port: 8087,
    hostname: '0.0.0.0',
    base: wpRoot,
    router: wpRoot + 'router.php'
  }, function () {
    // https://browsersync.io/docs/options
    browserSync({
      port: 8086,
      proxy: 'localhost:8087',
      notify: false,
      ghostMode: {
        clicks: true,
        forms: true,
        scroll: true
      }
    });
  });
});

gulp.task('bs-reload', function (done) {
  browserSync.reload();
  done();
});

gulp.task('build', gulp.series(gulp.parallel('webpack:dev')));

gulp.task('default', gulp.series(gulp.parallel('webpack:dev'), gulp.parallel('browser-sync',
  function (done) {
    // gulp.watch('js/*.js', gulp.series('jshint', 'js:dev'));
    // gulp.watch('sass/**/*.scss', gulp.series('sass:dev'));
    gulp.watch('**/*.php', gulp.series('phpcs', 'bs-reload'));
    gulp.watch('languages/*.mo', gulp.series('bs-reload'));
    done();
  }
)));


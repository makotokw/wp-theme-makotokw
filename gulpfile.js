/*jshint node: true */
'use strict';

var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var reload = browserSync.reload;
var del = require('del');
var notifier = require('node-notifier');

var wpRoot = '../../../';

gulp.task('clean:components', function () {
  return del([
    'components/font-awesome',
    'components/google-code-prettify',
    'components/html5shiv',
    'components/unsemantic'
  ]);
});
gulp.task('bower:install', plugins.shell.task(['bower install']));
gulp.task('bower:reinstall', gulp.series('clean:components', 'bower:install'));
gulp.task('bower:normalize', gulp.series('bower:reinstall'), function () {
  var mainBowerFiles = require('main-bower-files');
  var bowerNormalizer = require('gulp-bower-normalize');
  gulp.src(mainBowerFiles(), {base: './bower_components'})
    .pipe(bowerNormalizer({bowerJson: './bower.json', checkPath: true}))
    .pipe(plugins.rename(function (path) {
      if (path.dirname.match(/\/css$/)) {
        // for sass import
        path.dirname = path.dirname.replace(/\/css$/, '/scss');
        path.basename = '_' + path.basename;
        path.extname = '.scss';
      }
    }))
    .pipe(gulp.dest('./components/'));
});

gulp.task('phpcs', plugins.shell.task(
  'phpcs --colors -s --report-width=1024 --standard=build/phpcs.xml *.php ./**/*.php',
  {ignoreErrors: true}
));

gulp.task('jshint', function () {
  return gulp.src(['gulpfile.js', 'js/*.js'])
    .pipe(plugins.jshint())
    .pipe(plugins.jshint.reporter('jshint-stylish'))
    .pipe(plugins.if(!browserSync.active, plugins.jshint.reporter('fail')));
});

gulp.task('checkstyle', gulp.series('phpcs', 'jshint'));

gulp.task('make-languages-pot-1st', plugins.shell.task([
  'xgettext --from-code=UTF-8 -k__ -k_e -L PHP -o ./languages/messages.pot ./*.php ./*/*.php --package-name=makotokw --package-version=1.0 --msgid-bugs-address=makoto.kw@gmail.com',
  'msgmerge --update ./languages/ja.po ./languages/messages.pot --backup=off'
]));

gulp.task('make-languages-mo-2nd', plugins.shell.task([
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

// Modernizr
gulp.task('modernizr', function () {
  return gulp.src([
    './sass/**/*.scss',
    './components/**/*.js',
    './js/**/*.js',
    '!./js/vendor/modernizr/modernizr.js'
  ])
  // https://github.com/rejas/gulp-modernizr
  // https://github.com/Modernizr/customizr#config-file
    .pipe(plugins.modernizr({
      classPrefix: 'has-',
      enableClasses: true,
      tests: [
        'svg'
      ],
      options: [
        'setClasses'
      ]
    }))
    .pipe(gulp.dest('./js/vendor/modernizr'));
});

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

gulp.task('js:dev', gulp.series('modernizr'), function () {
  js('development');
});

gulp.task('js', gulp.series('modernizr'), function () {
  js('production');
});

function sass(env) {
  var isDebug = env === 'development';
  return plugins.rubySass('sass/*.scss', {
    verbose: isDebug,
    loadPath: ['components'],
    lineNumbers: isDebug,
    force: !isDebug,
    sourcemap: isDebug,
    emitCompileError: true
  })
    .on('error', function (err) {
      notifier.notify({
        message: err.message,
        title: err.plugin
      });
    })
    .pipe(plugins.plumber())
    .pipe(plugins.postcss([
      require('autoprefixer')({
        browsers: ['last 2 versions'],
        cascade: false
      })
    ]))
    .pipe(plugins.if(isDebug, plugins.sourcemaps.write()))
    .pipe(gulp.dest('.'))
    .pipe(reload({stream: true, once: true}));
}

gulp.task('sass:dev', function () {
  return sass('development');
});

gulp.task('sass', function () {
  return sass('production');
});

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

gulp.task('bs-reload', function () {
  browserSync.reload();
});

gulp.task('default', gulp.series('js:dev', 'sass:dev', 'browser-sync'),
  function () {
    gulp.watch('js/*.js', gulp.series('jshint', 'js:dev'));
    gulp.watch('sass/**/*.scss', gulp.series('sass:dev'));
    gulp.watch('**/*.php', gulp.series('phpcs', 'bs-reload'));
    gulp.watch('languages/*.mo', gulp.series('bs-reload'));
  }
);

gulp.task('build', gulp.series('js', 'sass', 'clean:map'));

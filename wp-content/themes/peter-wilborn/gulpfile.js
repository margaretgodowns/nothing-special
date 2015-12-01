var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync'),
    concat = require('gulp-concat'),
    eslint = require('gulp-eslint'),
    minifyCSS = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    package = require('./package.json');



gulp.task('css', function () {
    return gulp.src('./style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({errLogToConsole: true}))
    .pipe(autoprefixer({
      browsers: [
        'last 20 versions',
        '> 5%',
        'ie 8',
        'ie 9',
        'ie 10'
      ],
      remove: true,
      cascade: true
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./'))
    .pipe(browserSync.reload({stream:true}));
});

//
//   ES lint
//
//////////////////////////////////////////////////////////////////////

gulp.task('lint', function() {
  return gulp.src('./-/js/*.js')
    .pipe(eslint({
      rules: {
        'quotes': 0,
        'no-multi-spaces': [
          1, {
            'exceptions': {
              'VariableDeclarator': true
            }
          }
        ]
      },
      globals: {
        'jQuery':            false,
        '$':                 true,
        'imagesLoaded':      false,
        'Modernizr':         false,
        'templateDirectory': false,
        'Handlebars':        false,
        'IconicJS':          false,
        'ajaxpagination':    false
      },
      envs: [
        'browser'
      ]
    }))
    .pipe(eslint.format());
});


gulp.task('js', function(){
  return gulp.src([
      '-/js/plugins/**/*.js',
      '-/js/*.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(concat('scripts.js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .on('error', handleError)
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./-/js/'))
    .pipe(browserSync.reload({stream:true, once: true}));
});




gulp.task('browser-sync', function() {
    browserSync.init(null, {
        proxy: "local.dev",
    });
});
gulp.task('bs-reload', function () {
    browserSync.reload();
});

gulp.task('default', ['css', 'lint', 'js', 'browser-sync'], function () {
    gulp.watch("-/scss/*/*.scss", ['css']);
    gulp.watch("-/js/**/*.js", ['lint', 'js']);
    gulp.watch("./**/*.php", ['bs-reload']);
});


// Handle errors
function handleError (error) {
  //If you want details of the error in the console
  console.log('WARNING!', error.message.toString());
  this.emit('end');
}

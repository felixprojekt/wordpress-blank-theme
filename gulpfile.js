var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var rename = require("gulp-rename");
const babel = require('gulp-babel');
const minify = require("gulp-babel-minify");
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

gulp.task('sass', function (cb) {
    gulp
        .src('css/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: "compressed"
        }))
        .pipe(postcss([ autoprefixer() ]))
        .on('error', function (err) {
            console.log(err.toString());
            this.emit('end');
        })
        .pipe(sourcemaps.write('.'))
        .pipe(
            gulp.dest(function (f) {
                return f.base;
            })
        );
    cb();
});

gulp.task('js', function () {
    return gulp.src(['js/**/*.js', '!js/**/*.min.js']) // no need of reading file because browserify does.

        .pipe(sourcemaps.init())

        .pipe(babel({
            presets: ['@babel/preset-env']
        }))

        .pipe(rename({suffix: '.min'}))
    
        .pipe(minify({}))

        .pipe(sourcemaps.write('.'))

        .pipe(
            gulp.dest(function (f) {
                return f.base;
            })
        );
});

gulp.task(
    'default',
    gulp.series('sass', 'js', function (cb) {
        gulp.watch(['css/**/*.scss', 'js/**/*.js', '!js/**/*.min.js'], gulp.series('sass', 'js'));
        cb();
    })
);

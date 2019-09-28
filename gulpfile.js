var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function (cb) {
    gulp
        .src('css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: "compressed"
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(
            gulp.dest(function (f) {
                return f.base;
            })
        );
    cb();
});

gulp.task(
    'default',
    gulp.series('sass', function (cb) {
        gulp.watch('css/*.scss', gulp.series('sass'));
        cb();
    })
);
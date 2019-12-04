var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('styles', function() {
    return gulp.src('sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./webroot/css/'));
});

gulp.task('watch',function() {
    return gulp.watch('sass/**/*.scss', gulp.series('styles'));
});
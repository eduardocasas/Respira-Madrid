var gulp = require('gulp');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
 
gulp.task('minify-css', function () {
    return gulp.src('./www/Symfony/web/bundles/app/css/**/*.css')
        .pipe(minifyCss())
        .pipe(gulp.dest('./www/Symfony/web/bundles/app/css.min/'));
});
gulp.task('minify-js', function () {
    gulp.src('./www/Symfony/web/bundles/app/js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./www/Symfony/web/bundles/app/js.min/'));
});
gulp.task('lint', function() {
    return gulp.src('./www/Symfony/web/bundles/app/js/**/*.js')
        .pipe(jshint({ "multistr": true, "laxbreak": true }))
        .pipe(jshint.reporter());
});

gulp.task('default', ['minify-css', 'minify-js', 'lint']);
/*
 * Copyright (C) 2017 Adam Faryna <adamfaryna@appdy.net>
 *
 * Distributed under terms of the GNU GPL v3.0 license.
 */
const gulp = require('gulp');
const watch = require('gulp-watch');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');

const srcPath = './sass/**/*.scss';

gulp.task('sass', () => {
  return gulp.src(srcPath)
    .pipe(sass.sync().on('error', sass.LogError))
    .pipe(gulp.dest('./'));
});

gulp.task('sass:watch', () => {
  watch(srcPath, ['sass']);
});

gulp.task('sass:prod', () => {
  return gulp.src(srcPath)
    .pipe(sourcemaps.init())
    .pipe(sass.sync().on('error', sass.LogError))
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./'));
});


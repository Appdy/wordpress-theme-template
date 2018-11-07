import fs from 'fs';
import path from 'path';

import gulp from 'gulp';

// Load all gulp plugins automatically
// and attach them to the `plugins` object
import plugins from 'gulp-load-plugins';

// Temporary solution until gulp 4
// https://github.com/gulpjs/gulp/issues/355
import runSequence from 'run-sequence';

import archiver from 'archiver';
import glob from 'glob';
import del from 'del';
import ssri from 'ssri';
import modernizr from 'modernizr';
import strip from 'gulp-strip-comments'

import pkg from './package.json';
import modernizrConfig from './modernizr-config.json';
import prettify from 'gulp-html-prettify'

const USE_HTML = false

const AUTOPREFIXER_BROWSERS = [
  'ie >= 10',
  'ie_mob >= 10',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 7',
  'android >= 4.4',
  'bb >= 10'
];

// const dirs = pkg['h5bp-configs'].directories;

const input = {
  style: './src/style/style.scss',
  js: './src/js/**/*.js',
  fonts: './src/fonts/**',
  // imgs: './src/img/**',
  vendorJs: './src/vendor/js'
}

const output = {
  style: './',
  js: './',
  html: './',
  // imgs: './/',
  fonts: './',
  vendorJs: './'
}

let isDevelMode = true

// ---------------------------------------------------------------------
// | Helper tasks                                                      |
// ---------------------------------------------------------------------

// gulp.task('archive:create_archive_dir', () => {
//   fs.mkdirSync(path.resolve(dirs.archive), '0755');
// });

// gulp.task('archive:zip', (done) => {
//   const archiveName = path.resolve(dirs.archive, `${pkg.name}_v${pkg.version}.zip`);
//   const zip = archiver('zip');
//   const files = glob.sync('**/*.*', {
//     'cwd': dirs.dist,
//     'dot': true // include hidden files
//   });
//   const output = fs.createWriteStream(archiveName);

//   zip.on('error', (error) => {
//     done();
//     throw error;
//   });

//   output.on('close', done);

//   files.forEach((file) => {
//     const filePath = path.resolve(dirs.dist, file);

//     // `zip.bulk` does not maintain the file
//     // permissions, so we need to add files individually
//     zip.append(fs.createReadStream(filePath), {
//       'name': file,
//       'mode': fs.statSync(filePath).mode
//     });
//   });

//   zip.pipe(output);
//   zip.finalize();
// });

gulp.task('clean', done => {
  del([
    // dirs.archive,
    "./styles.css",
    "./styles.css.map"
  ]).then(() => {
    done()
  })
})

gulp.task('copy', [
  'copy:.htaccess',
  // 'copy:index.html',
  // 'copy:jquery',
  // 'copy:license',
  // 'copy:main.css',
  // 'copy:misc',
  // 'copy:normalize'
]);

gulp.task('copy:.htaccess', () =>
  gulp.src('node_modules/apache-server-configs/dist/.htaccess')
    .pipe(plugins().replace(/# ErrorDocument/g, 'ErrorDocument'))
    .pipe(gulp.dest(dirs.dist))
);

gulp.task('copy:jquery', () =>
  gulp.src(['node_modules/jquery/dist/jquery.min.js'])
    .pipe(plugins().rename(`jquery-${pkg.devDependencies.jquery}.min.js`))
    .pipe(gulp.dest(`${dirs.dist}/js/vendor`))
);

// gulp.task('copy:license', () =>
//   gulp.src('LICENSE.txt')
//     .pipe(gulp.dest(dirs.dist))
// );

// gulp.task('copy:main.css', () => {
//   // const banner = `/*! HTML5 Boilerplate v${pkg.version} | ${pkg.license} License | ${pkg.homepage} */\n\n`;

//   gulp.src(`${dirs.src}/css/main.css`)
//     // .pipe(plugins().header(banner))
//     // .pipe(plugins().autoprefixer({
//     //   browsers: ['last 2 versions', 'ie >= 9', '> 1%'],
//     //   cascade: false
//     // }))
//     .pipe(gulp.dest(`${dirs.dist}/css`));
// });

// gulp.task('copy:misc', () =>
//   gulp.src([

//     // Copy all files
//     `${dirs.src}`,

//     // Exclude the following files
//     // (other tasks will handle the copying of these files)
//     `!${dirs.src}/css/main.css`,
//     `!${dirs.src}/index.html`

//   ], {

//     // Include hidden files by default
//     dot: true

//   }).pipe(gulp.dest(dirs.dist))
// );

gulp.task('copy:normalize', () =>
  gulp.src('node_modules/normalize.css/normalize.css')
    .pipe(gulp.dest(`${dirs.dist}/css`))
);

gulp.task('copy:js', () => {
  return gulp.src(files.js).pipe(gulp.dest())
})

gulp.task('modernizr', (done) =>{
  modernizr.build(modernizrConfig, (code) => {
    if (!fs.existsSync(output.vendorJs)){
      fs.mkdirSync(output.vendorJs);
    }

    fs.writeFile(`${output.vendorJs}/modernizr-${pkg.devDependencies.modernizr}.min.js`, code, done);
  });
});

gulp.task('lint:js', () =>
  gulp.src([
    'gulpfile.js',
    input.js,
  ]).pipe(plugins().jscs())
    .pipe(plugins().eslint())
    .pipe(plugins().eslint.failOnError())
);

gulp.task('process:style', done => {
  let result = gulp.src(input.style)
    .pipe(plugins().sass().on('error', plugins().sass.logError))
    .pipe(plugins().autoprefixer({
      browsers: AUTOPREFIXER_BROWSERS,
      cascade: true
    }))

  if (!isDevelMode) {
    result = result
      .pipe(strip())
      .pipe(plugins().csso())
      // .pipe(browserSync.stream())
      // .pipe(browserSync.reload({stream: true}))
  }

  return result
    .pipe(plugins().rename({ basename: "styles"}))
    .pipe(gulp.dest(output.style))
});

gulp.task('process:js', done => {
  let result = gulp.src(input.js)

  if (!isDevelMode) {
    result = result
      .pipe(strip())
      .pipe(plugins().uglify())
  }

  return result.pipe(gulp.dest(output.js))
})

gulp.task('process:html', done => {
  const hash = ssri.fromData(
    fs.readFileSync('node_modules/jquery/dist/jquery.min.js'),
    {algorithms: ['sha256']}
  );
  const jQueryVersion = pkg.devDependencies.jquery;
  const modernizrVersion = pkg.devDependencies.modernizr;

  let result = gulp.src(input.html)
    .pipe(plugins().replace(/{{JQUERY_VERSION}}/g, jQueryVersion))
    .pipe(plugins().replace(/{{MODERNIZR_VERSION}}/g, modernizrVersion))
    .pipe(plugins().replace(/{{JQUERY_SRI_HASH}}/g, hash.toString()))

  if (!isDevelMode) {
    result = result.pipe(plugins().htmlmin({
      collapseWhitespace: true,
      removeComments: true
    }))
  }

  return result.pipe(gulp.dest(output.html))
})

gulp.task('process:pug', done => {
  const modernizrVersion = pkg.devDependencies.modernizr;

  let result = gulp.src(input.pug)
      .pipe(plugins().pug())
      .pipe(plugins().replace(/{{MODERNIZR_VERSION}}/g, modernizrVersion))

  if (isDevelMode) {
    result = result.pipe(prettify({indent_char: ' ', indent_size: 2}))

  } else {
    result = result.pipe(plugins().htmlmin({
      collapseWhitespace: true,
      removeComments: true
    }))
  }

  return result.pipe(gulp.dest(output.html))
})

gulp.task('copy:imgs', () => {
  return gulp.src(input.imgs, { base: "./src"})
    .pipe(gulp.dest(output.imgs))
})

gulp.task('copy:fonts', () => {
  return gulp.src(input.fonts, { base: "./src"})
    .pipe(gulp.dest(output.fonts))
})

gulp.task('process:imgs', ['copy:imgs'])
gulp.task('process:fonts', ['copy:fonts'])

gulp.task('process', [
  // 'process:imgs',
  'process:fonts',
  'process:style',
  'process:js'
])

gulp.task('watch', [
  'watch:style',
  'watch:js',
  'watch:assets'
  // USE_HTML ? 'watch:html' : 'watch:pug'
])

gulp.task('watch:style', () => {
  gulp.watch(input.style, ['process:style'])
})

gulp.task('watch:js', () => {
  gulp.watch(input.js, ['process:js', 'lint:js'])
})

gulp.task('watch:html', () => {
  gulp.watch(input.html, ['process:html'])
})

gulp.task('watch:pug', () => {
  gulp.watch(input.pug, ['process:pug'])
})

gulp.task('watch:assets', () => {
  gulp.watch(input.imgs, ['process:imgs'])
  gulp.watch(input.fonts, ['process:fonts'])
})

gulp.task('mode:prod', () => {
  isDevelMode = false
})

gulp.task('mode:devel', () => {
  isDevelMode = true
})

// ---------------------------------------------------------------------
// | Main tasks                                                        |
// ---------------------------------------------------------------------

gulp.task('archive', (done) => {
  runSequence(
    'build',
    'archive:create_archive_dir',
    'clean',
    'archive:zip',
    done);
});

gulp.task('devel', done => {
  runSequence(
    'mode:devel',
    'clean',
    // ['clean', 'lint:js'],
    'process',
    // 'copy',
    'modernizr',
    'watch', done)
})

gulp.task('prod', (done) => {
  runSequence(
    'mode:prod',
    ['clean', 'lint:js'],
    'process',
    // 'copy',
    'modernizr',
    done);
});

gulp.task('default', ['devel']);

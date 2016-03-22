/* ===========================================================================
 Barebones Gulpfile
 ============================================================================= */

// Gulp
var gulp = require('gulp'),
    browsersync = require('browser-sync'),
    cssnano = require('cssnano'),
    cssimport = require('postcss-import'),
    autoprefixer = require('autoprefixer'),
    $ = require( 'gulp-load-plugins' )(),

    // Environment variable to set dev or prod
    env = (function() {
    		var env = 'dev';

    		/** Test if there was a different value from CLI to env
    			Ex: gulp styles --env=production */
    		process.argv.some(function( key ) {
    			var matches = key.match( /^\-{2}env\=([A-Za-z]+)$/ );

    			if ( matches && matches.length === 2 ) {
    				env = matches[1];
    				return true;
    			}
    		});

    		return env;
    	} ()),

    // Paths
    paths = {
        scss: 'src/sass/**/*.scss',
        css_dest: 'assets/css/',
		scripts: 'src/scripts/partials/**/*.js',
		js_dest: 'assets/js'
    },

    // JS Configurations
    jsConfig = require('./src/scripts/config.json');

// BrowserSync proxy
gulp.task('browsersync', function () {
    browsersync({
        proxy: 'dev_URL',
        open: false
    });
});

// CSS
gulp.task('styles', function() {

    var stream = gulp.src(paths.scss)
        .pipe($.if(env === 'dev', $.sourcemaps.init()))
        .pipe($.sass()).on("error", function(e) {
            console.error(e.toString());
        })
        .pipe($.postcss([
            autoprefixer(),
            cssimport()
        ]))
        .pipe($.if(env === 'prod', $.postcss([
            cssnano()
        ])))
        .pipe($.if(env === 'dev', $.sourcemaps.write()));

        return stream.on("error", function(e) {
            console.error(e);
        }).pipe(gulp.dest(paths.css_dest));
});

// JS: Authoring
gulp.task('scripts', function() {

    gulp.src(jsConfig.dependencies.concat(paths.scripts))
            .pipe($.expectFile({ errorOnFailure: true }, [jsConfig.dependencies, paths.scripts]))
                .on('error', function(err) {
                    console.error(err);
                })
            .pipe($.concat(jsConfig.outputFileName))
            .pipe($.if(env === 'dev', $.sourcemaps.init()))
            .pipe($.if(env === 'prod', $.uglify()))
            .pipe($.rename({suffix: '.min'}))
            .pipe($.if(env === 'dev', $.sourcemaps.write()))
            .pipe(gulp.dest(paths.js_dest));
});

// Move public dependencies to the correct directory
gulp.task('public', function() {
    gulp.src(jsConfig.public)
        .pipe($.expectFile({ errorOnFailure: true }, jsConfig.public))
            .on('error', function(err) {
                console.error(err);
            })
        .pipe($.if(env === 'prod', $.uglify()))
        .pipe(gulp.dest('assets/js/vendor'));
});

// JS Hint
gulp.task('jshint', function() {
    gulp.src('src/scripts/**/*.js')
        .pipe($.jshint())
        .pipe($.jshint.reporter( "jshint-stylish" ))
        .pipe($.jshint.reporter( "fail" ));
});

// Env to Prod
gulp.task( "envProduction", function() {
	env = 'prod';
});

// Local/Dev
gulp.task('default', ['styles', 'scripts', 'public', 'jshint']);

// Production
gulp.task('prod', ['envProduction', 'styles', 'scripts', 'public']);

// Watch
gulp.task('watch', ['browsersync'], function () {

    // Watch .scss files
    gulp.watch(paths.scss, ['styles']).on('change', browsersync.reload);

    //Watch .js files
    gulp.watch(paths.scripts, ['scripts', 'jshint']).on('change', browsersync.reload);

});

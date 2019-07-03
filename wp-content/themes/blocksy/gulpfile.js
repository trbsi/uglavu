const gulp = require('gulp')
const buildProcess = require('ct-build-process')
const removeCode = require('gulp-remove-code')
const shell = require('gulp-shell')

const data = require('./package.json')

var options = {
	packageType: 'wordpress_theme',
	packageSlug: 'blocksy',
	packageI18nSlug: 'blocksy',

	entries: [
		{
			entry: './static/js/main.js',
			output: {
				path: './static/bundle/',
				chunkFilename: '[id].[chunkhash].js'
			}
		},

		{
			entry: './static/js/options.js',
			output: {
				filename: 'options.js',
				path: './static/bundle/',
				chunkFilename: '[id].[chunkhash].js'
			},

			externals: {
				_: 'window._',
				jquery: 'window.jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'window.ctEvents',
				underscore: 'window._',
				'@wordpress/element': 'window.wp.element',
				'@wordpress/components': 'window.wp.components',
				'@wordpress/date': 'window.wp.date',
				react: 'React',
				'react-dom': 'ReactDOM'
			}
		},

		{
			entry: './static/js/customizer/sync.js',
			output: {
				filename: 'sync.js',
				path: './static/bundle/'
			},
			externals: {
				_: 'window._',
				jquery: 'window.jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'window.ctEvents',
				underscore: 'window._',
				'@wordpress/element': 'window.wp.element',
				'@wordpress/components': 'window.wp.components',
				'@wordpress/date': 'window.wp.date',
				react: 'React',
				'react-dom': 'ReactDOM'
			}
		},

		{
			entry: './static/js/customizer/controls.js',
			output: {
				filename: 'customizer-controls.js',
				path: './static/bundle/'
			},
			externals: {
				_: 'window._',
				jquery: 'window.jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'window.ctEvents',
				underscore: 'window._',
				'@wordpress/element': 'window.wp.element',
				'@wordpress/components': 'window.wp.components',
				'@wordpress/date': 'window.wp.date',
				react: 'React',
				'react-dom': 'ReactDOM'
			}
		},

		{
			entry: './admin/dashboard/static/js/main.js',
			output: {
				path: './admin/dashboard/static/bundle'
			},
			externals: {
				jquery: 'window.jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'window.ctEvents',
				underscore: 'window._',
				'@wordpress/element': 'window.wp.element',
				'@wordpress/date': 'window.wp.date',
				react: 'React',
				'react-dom': 'ReactDOM'
			}
		}
	],

	sassFiles: [
		{
			input: 'static/sass/main.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data)
		},

		{
			input: 'static/sass/woocommerce.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data)
		},

		{
			input: 'static/sass/editor.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data)
		},

		{
			input: 'static/sass/customizer-controls.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data)
		},

		{
			input: 'static/sass/options.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data)
		},

		{
			input: 'admin/dashboard/static/sass/main.scss',
			output: 'admin/dashboard/static/bundle',
			header: buildProcess.headerFor(false, data)
		}
	],

	browserSyncEnabled: true,

	sassWatch: [
		'static/sass/**/*.scss',
		'admin/dashboard/static/sass/**/*.scss'
	],

	webpackExternals: {
		jquery: 'window.jQuery',
		'ct-i18n': 'window.wp.i18n',
		'ct-events': 'window.ctEvents',
		underscore: 'window._',
		'@wordpress/element': 'window.wp.element',
		'@wordpress/date': 'window.wp.date'
	},

	webpackResolveAliases: {
		'ct-log': 'ct-wp-js-log'
	},

	babelAdditionalPlugins: [
		'@babel/plugin-proposal-class-properties',
		'babel-plugin-lodash'
	],

	modulesToCompileWithBabel: ['@wordpress/element'],

	filesToDeleteFromBuild: [
		'./build_tmp/build/node_modules/',
		'./build_tmp/build/phpcs.xml.dist',
		'./build_tmp/build/child-theme/',
		'./build_tmp/build/composer.json',
		'./build_tmp/build/yarn.lock',
		'./build_tmp/build/wp-cli.yml',
		'./build_tmp/build/docs',
		'./build_tmp/build/extensions.json',
		// './build_tmp/build/gulpfile.js',
		// './build_tmp/build/package.json',
		'./build_tmp/build/psds',
		'./build_tmp/build/ruleset.xml',
		'./build_tmp/build/tests',
		'./build_tmp/build/inc/browser-sync.php'
		// './build_tmp/build/admin/dashboard/static/{js,sass}',
		// './build_tmp/build/static/{js,sass}'
	],

	toClean: ['static/bundle/', 'admin/dashboard/static/bundle/'],

	babelJsxPlugin: 'react',
	babelJsxReactPragma: 'createElement'
}

gulp.task(
	'build:before_creating_zips',

	() =>
		gulp
			.src('./build_tmp/build/functions.php')
			.pipe(removeCode({ production: true }))
			.pipe(gulp.dest('./build_tmp/build'))
)

buildProcess.registerTasks(gulp, options)

gulp.task(
	'gettext-generate-js',
	shell.task(['NODE_ENV_GETTEXT=true NODE_ENV=production yarn gulp build'], {
		ignoreErrors: true,
		verbose: true
	})
)

gulp.task(
	'gettext-generate',
	gulp.series(
		'gettext-generate-js',
		'gettext-generate:php',
		shell.task(
			[
				"msgcat $(find -L . -name \"blocksy-php.pot\" | grep -v 'node_modules') $(find -L . -name \"ct-js.pot\" | grep -v 'node_modules') | grep -v '#-#-#-#' > ./languages/blocksy.pot && rm ./languages/blocksy-php.pot ./languages/ct-js.pot"
			],
			{
				ignoreErrors: true,
				verbose: true
			}
		),

		shell.task(['yarn build'], {
			ignoreErrors: true,
			verbose: true
		})
	)
)

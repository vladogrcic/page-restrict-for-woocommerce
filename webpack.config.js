const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
// Load the default @wordpress/scripts config object
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

// Use the defaultConfig but replace the entry and output properties
module.exports = {
	...defaultConfig,
	resolve: {
		alias: {
			nm: path.join(__dirname, 'node_modules')
		}
	},
	entry: {
		'admin-script': path.resolve(
			process.cwd(),
			'admin/assets/src/js',
			'admin.js'
		),
		'sidebars': path.resolve(
			process.cwd(),
			'admin/assets/src/js',
			'sidebars.js'
		),
		'blocks': path.resolve(
			process.cwd(), 
			'admin/assets/src/js', 
			'blocks.js'
		),
		'general-block-var': path.resolve(
			process.cwd(),
			'admin/assets/src/js/main',
			'general-block-var.js'
		),

		'admin-style': path.resolve(
			process.cwd(),
			'admin/assets/src/scss',
			'admin.scss'
		),
		'gutenberg': path.resolve(
			process.cwd(),
			'admin/assets/src/scss',
			'gutenberg.scss'
		),

		'jquery-ui': path.resolve(
			process.cwd(),
			'admin/assets/src/css/lib',
			'jquery-ui.css'
		),
		'jquery-ui.theme': path.resolve(
			process.cwd(),
			'admin/assets/src/css/lib',
			'jquery-ui.theme.css'
		),
		'zoomify': path.resolve(
			process.cwd(),
			'admin/assets/src/css/lib',
			'zoomify.css'
		),
	},
	output: {
		filename: '[name].js',
		path: __dirname + '/admin/assets/build',
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(png|jpg|gif)$/i,
				use: [
					{
						loader: 'url-loader',
						options: {
							limit: 8192,
						},
					},
				],
			},
		],
	},
	plugins: [
		...defaultConfig.plugins,
		new CopyWebpackPlugin({
			patterns: [
				{
					from: path.resolve(
						process.cwd(),
						'node_modules/slim-select/dist/slimselect.css'
					),
					to: path.resolve(process.cwd(), 'admin/assets/build'),
				},
			],
		}),
		new CopyWebpackPlugin({
			patterns: [
				{
					from: path.resolve(
						process.cwd(),
						'node_modules/slim-select/dist/slimselect.js'
					),
					to: path.resolve(process.cwd(), 'admin/assets/build'),
				},
			],
		}),
		new CopyWebpackPlugin({
			patterns: [
				{
					from: path.resolve(
						process.cwd(),
						'node_modules/jquery-zoom/jquery.zoom.js'
					),
					to: path.resolve(process.cwd(), 'admin/assets/build'),
				},
			],
		}),
	],
};

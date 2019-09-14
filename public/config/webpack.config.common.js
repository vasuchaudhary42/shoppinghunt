'use strict';

const CleanWebpackPlugin   = require('clean-webpack-plugin');
const HtmlWebpackPlugin    = require('html-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
// const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const helpers              = require('./helpers');
const isDev                = process.env.NODE_ENV !== 'production';

module.exports = {
    entry: {
        vendor: './src/vendor.ts',
        polyfills: './src/polyfills.ts',
        main: isDev ? './src/main.ts' : './src/main.aot.ts'
    },
    resolve: {
        extensions: ['.ts', '.js', '.scss', '.less', '.css', '.gz' ]
    },
    optimization: {
        minimizer: [new UglifyJsPlugin()],
    },
    devServer: {
        contentBase: './dist'
    },
    module: {
        rules: [
            {
                test: /\.gz$/,
                enforce: 'pre',
                use: 'gzip-loader'
            },
            {
                test: /\.(png|jp(e*)g|svg)$/,
                use: [{
                    loader: 'url-loader',
                    options: {
                        limit: 8000, // Convert images < 8kb to base64 strings
                        name: 'images/[hash]-[name].[ext]'
                    }
                }]
            },
            {
                test: /\.css$/,
                use: [
                    'to-string-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true
                        }
                    }
                    // {
                    //     loader: 'raw-loader', // compiles Less to CSS
                    // },
                ]
            },
            {
                test: /\.html$/,
                loader: 'html-loader'
            },
            {
                test: /\.less$/,
                use: [
                    {
                        loader: 'style-loader', // creates style nodes from JS strings
                    },
                    {
                        loader: 'css-loader', // translates CSS into CommonJS
                    },
                    {
                        loader: 'less-loader', // compiles Less to CSS
                    },
                ],
            },
        ]
    },
    plugins: [
        new CleanWebpackPlugin('style-loader',
            helpers.root('dist'), { root: helpers.root(), verbose: true }),
        new HtmlWebpackPlugin({
            template: 'src/index.html'
        }),
        new CompressionPlugin(),
    ]
};

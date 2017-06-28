const merge = require('webpack-merge');
const webpack = require('webpack');
const baseWebpackConfig = require('./webpack.base');
const path = require('path');
const projectRoot = path.resolve(__dirname, './');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = merge(baseWebpackConfig, {
  output: {
    path: projectRoot + '/assets',
    filename: '[name].[hash].package.js'
  },
  plugins: [
    new ExtractTextPlugin({
      filename: '[name].[hash].package.css',
      allChunks: true,
    }),
    new webpack.optimize.UglifyJsPlugin({ // https://github.com/angular/angular/issues/10618
      mangle: {
        keep_fnames: true
      }
    }),
    new webpack.LoaderOptionsPlugin({
      htmlLoader: {
        minimize: false // workaround for ng2
      }
    }),
    new webpack.DefinePlugin({
      __IN_DEBUG__: JSON.stringify(false)
    }),
  ],
});

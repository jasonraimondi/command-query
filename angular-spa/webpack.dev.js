const webpack = require('webpack');
const merge = require('webpack-merge');
const path = require('path');
const tslint = require('./tslint');

const PrettierPlugin = require('prettier-webpack-plugin');
const prettierRules = require('./prettier.rules.json');

const baseWebpackConfig = require('./webpack.base');

module.exports = merge(baseWebpackConfig, {
  module: {
    rules: [
      {
        test: /\.ts$/,
        enforce: 'pre',
        loader: 'tslint-loader',
        options: tslint
      },
    ]
  },
  devtool: 'eval-source-map',
  devServer: {
    contentBase: path.join(__dirname, 'dist'),
    compress: true,
    historyApiFallback: true,
    inline: true,
    port: 9000,
    stats: 'minimal'
  },
  plugins: [
    new PrettierPlugin(prettierRules),
    new webpack.DefinePlugin({
      __IN_DEBUG__: JSON.stringify(true)
    }),
  ],
});

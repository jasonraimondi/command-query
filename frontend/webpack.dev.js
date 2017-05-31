const path = require('path');

const webpack = require('webpack');
const merge = require('webpack-merge');
const HtmlWebpackPlugin = require('html-webpack-plugin');

const baseWebpackConfig = require('./webpack.base');
const projectRoot = path.resolve(__dirname, './');

module.exports = merge(baseWebpackConfig, {
  devtool: 'eval-source-map',
  devServer: {
    contentBase: path.join(__dirname, "dist"),
    compress: true,
    inline: true,
    port: 9000,
  },
  plugins: [
    new webpack.DefinePlugin({
      PRODUCTION: JSON.stringify(false),
    }),
    new HtmlWebpackPlugin({
      template: projectRoot + '/src/index.html'
    }),
  ],
});

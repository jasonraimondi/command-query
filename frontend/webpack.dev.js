const webpack = require('webpack');
const merge = require('webpack-merge');
const path = require('path');

const baseWebpackConfig = require('./webpack.base');

module.exports = merge(baseWebpackConfig, {
  devtool: 'eval-source-map',
  devServer: {
    contentBase: path.join(__dirname, "dist"),
    compress: true,
    historyApiFallback: true,
    inline: true,
    port: 9000,
    stats: 'minimal'
  },
  plugins: [
    new webpack.DefinePlugin({
      __IN_DEBUG__: JSON.stringify(true)
    }),
  ],
});

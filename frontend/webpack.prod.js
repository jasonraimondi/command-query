const merge = require('webpack-merge');
const webpack = require('webpack');
const baseWebpackConfig = require('./webpack.base');

module.exports = merge(baseWebpackConfig, {
  plugins: [
    // new webpack.optimize.UglifyJsPlugin({ // https://github.com/angular/angular/issues/10618
    //   mangle: {
    //     keep_fnames: true
    //   }
    // }),
    new webpack.LoaderOptionsPlugin({
      htmlLoader: {
        minimize: false // workaround for ng2
      }
    }),
    new webpack.DefinePlugin({
      PRODUCTION: JSON.stringify(true),
    }),
  ],
});

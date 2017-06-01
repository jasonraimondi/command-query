const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const webpack = require('webpack');
const path = require('path');

const projectRoot = path.resolve(__dirname, './');
const pathsToClean = ['dist'];
const cleanOptions = {
  root: projectRoot,
  verbose: true,
  dry: false
};


module.exports = {
  context: projectRoot + '/src',
  entry: {
    polyfills: projectRoot + '/src/polyfills.ts',
    vendor: projectRoot + '/src/vendor.ts',
    app: projectRoot + '/src/main.ts',
  },
  output: {
    path: projectRoot + '/dist',
    filename: 'js/[name].[hash].package.js'
  },
  resolve: {
    extensions: ['.ts', '.js', '.css', '.scss', '.html', '.svg', '.jpg', '.jpeg', '.png', '.gif'],
  },
  module: {
    rules: [
      {
        test: /\.(html|css)$/,
        use: 'raw-loader',
      },
      {
        test: /\.ts$/,
        loaders: ['awesome-typescript-loader', 'angular2-template-loader'],
        exclude: /node_modules/,
      },
      {
        test: /\.(css|scss)$/,
        loader: ExtractTextPlugin.extract({
          use: 'css-loader!sass-loader',
          fallback: 'style-loader',
        }),
      },
      {
        test: /\.(jpe?g|png|gif|svg)$/,
        loaders: [
          'file-loader?hash=sha512&digest=hex&name=[name]_[hash].[ext]&outputPath=images/',
          'image-webpack-loader?bypassOnDebug&optimizationLevel=7&interlaced=false'
        ]
      },
    ],
  },
  plugins: [
    new webpack.NoEmitOnErrorsPlugin(),
    new CleanWebpackPlugin(pathsToClean, cleanOptions),
    new ExtractTextPlugin({
      filename: 'css/[name].[hash].package.css',
      allChunks: true,
    }),
    new HtmlWebpackPlugin({
      template: projectRoot + '/src/index.html'
    }),

    // @see https://github.com/angular/angular/issues/14898#issuecomment-284039716
    new webpack.ContextReplacementPlugin(
      /angular(\\|\/)core(\\|\/)@angular/,
      projectRoot + '/src'
    ),


    // @see https://angular.io/docs/ts/latest/guide/webpack.html#!#commons-chunk-plugin
    //
    // The CommonsChunkPlugin identifies the hierarchy among three chunks: app -> vendor -> polyfills.
    // Where Webpack finds that app has shared dependencies with vendor, it removes them from app. It
    // would remove polyfills from vendor if they shared dependencies, which they don't.
    new webpack.optimize.CommonsChunkPlugin({
      name: ['app', 'vendor', 'polyfills']
    }),
  ],
};

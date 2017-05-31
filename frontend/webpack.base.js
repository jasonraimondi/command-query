const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
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
    // polyfills: projectRoot + '/src/polyfills.ts',
    // vendor: projectRoot + '/src/vendor.ts',
    app: projectRoot + '/src/main.ts',
  },
  output: {
    path: projectRoot + '/dist',
    filename: '[name].package.js',
    chunkFilename: '[id].[hash].chunk.js'
  },
  resolve: {
    extensions: ['.ts', '.js', '.css', '.scss', '.html', '.svg', '.jpg', '.jpeg', '.png', '.gif'],
  },
  module: {
    rules: [
      {
        test: /\.html$/,
        use: [{
          loader: 'html-loader',
          options: {
            minimize: true,
            removeComments: false,
            collapseWhitespace: false
          }
        }],
      },
      {
        test: /\.ts$/,
        loader: 'awesome-typescript-loader',
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
    // new webpack.optimize.CommonsChunkPlugin({
    //   name: ['app', 'vendor', 'polyfills'],
    //   filename: '[name].[hash].common.js'
    // }),
    new CleanWebpackPlugin(pathsToClean, cleanOptions),
    new ExtractTextPlugin({
      filename: 'css/[name].[hash].package.css',
      allChunks: true,
    }),
  ],
};

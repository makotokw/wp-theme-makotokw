const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

// noinspection JSUnusedGlobalSymbols
module.exports = {
  entry: {
    style: ['./src/styles/style.scss', './src/scripts/index.js'],
    'style-editor': ['./src/styles/style-editor.scss'],
    amazonjs: ['./src/styles/amazonjs.scss'],
  },
  output: {
    path: path.resolve(__dirname, '../dist'),
    filename: '[name].js',
  },
  module: {
    rules: [
      // Headroom.js dose not support modules yet
      // https://github.com/WickyNilliams/headroom.js/issues/140
      {
        test: require.resolve('headroom.js'),
        use: [{
          loader: 'expose-loader',
          options: {
            exposes: 'Headroom',
          },
        }],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          'babel-loader',
          'eslint-loader',
        ],
      },
      {
        test: /\.s?css$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            },
          },
        ],
      },
      {
        // for Font Awesome
        test: /\.(ttf|eot|woff|woff2|svg)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              outputPath: 'fonts',
            },
          },
        ],
      },
    ],
  },
  plugins: [
    // https://webpack.js.org/plugins/mini-css-extract-plugin/
    new MiniCssExtractPlugin({
      filename: (pathData) => (pathData.chunk.name === 'amazonjs' ? '../[name].css' : '[name].css'),
      ignoreOrder: false,
    }),
    // https://github.com/Turbo87/webpack-notifier
    new WebpackNotifierPlugin({
      skipFirstNotification: true,
    }),
    // https://github.com/johnagan/clean-webpack-plugin
    new CleanWebpackPlugin({}),
  ],
  externals: {
    jquery: 'jQuery',
  },
};

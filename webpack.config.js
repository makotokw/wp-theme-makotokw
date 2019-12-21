const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
  entry: {
    style: ['./src/styles/style.scss', './src/scripts/index.js'],
    amazonjs: ['./src/styles/amazonjs.scss'],
  },
  output: {
    path: path.resolve(__dirname, 'assets'),
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
          options: 'Headroom',
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
  devtool: 'source-map',
  plugins: [
    // https://webpack.js.org/plugins/mini-css-extract-plugin/
    new MiniCssExtractPlugin({
      moduleFilename: (chunk) => (chunk.name === 'amazonjs' ? '../[name].css' : '[name].css'),
      ignoreOrder: false,
    }),
    // https://github.com/johnagan/clean-webpack-plugin
    new CleanWebpackPlugin({
      verbose: true,
      cleanStaleWebpackAssets: false,
      cleanOnceBeforeBuildPatterns: ['**/*', '!images/**'],
    }),
  ],
  externals: {
    jquery: 'jQuery',
  },
};

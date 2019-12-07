const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    style: ['./src/styles/style.scss', './src/index.js'],
  },
  output: {
    path: path.resolve(__dirname, 'dist'),
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
          'css-loader',
          'postcss-loader',
          'sass-loader',
        ],
      },
    ],
  },
  devtool: 'source-map',
  plugins: [
    new MiniCssExtractPlugin({ filename: '[name].css', ignoreOrder: false }),
  ],
};
module.exports = function (env) {
  if (env && env.prod) {
    return require(`./build/webpack.prod.js`);
  }
  return require(`./build/webpack.dev.js`);
};

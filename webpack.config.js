const path = require('path')

module.exports = {
 //performance: { hints: false },
 //mode: 'development',
 devServer: {
  port: 9000
 },
 entry: {
  main: path.resolve(__dirname, './src/index.js')
 },
 output: {
  path: path.resolve(__dirname, './public/js'),
  filename: '[name].js'
 },
 module: {
  rules: [{
   test: '/\.js$/',
   loader: 'babel-loader',
   exclude: ['node_modules', './src/templates'],
  }, {
   test: '/\.html$/',
   use: [{
    loader: 'html-loader',
    options: {
     minimize: true
    }
   }]
  }]
 }
}
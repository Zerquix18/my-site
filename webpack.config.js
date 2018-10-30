/**
 * So basically this is the first time I ever try webpack.
 */

const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../css/app.css",
      chunkFilename: "[id].css"
    }),
    new VueLoaderPlugin()
  ],
  entry: {
    main: "./src/assets/js/app.js",
  },
  output: {
    path: path.resolve(__dirname, 'src/public/js/'),
    filename: "app.js",
  },
  module : {
    rules : [
      {
        test: /\.s?[ac]ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          { loader: 'css-loader', options: { url: false, sourceMap: true } },
          { loader: 'sass-loader', options: { sourceMap: true } }
        ],
      },
      {
        test: /\.vue$/,
        use: 'vue-loader'
      }
    ]
  },
};

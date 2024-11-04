const webpack = require("webpack");
const path = require("path");
const glob = require("glob");
const globSassImporter = require("node-sass-glob-importer");
const TerserPlugin = require("terser-webpack-plugin");
const autoprefixer = require("autoprefixer");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const SpriteLoaderPlugin = require("svg-sprite-loader/plugin");

module.exports = (env, argv) => {
  const directory = path.resolve(".");
  const workspace = path.parse(directory).base;

  // Get entry points from the package directory.
  const entries = {};
  glob.sync(`${directory}/src/*.js`).forEach((file) => {
    const { name } = path.parse(file);
    entries[name === "index" ? workspace : name] = file;
  });
  if (!Object.keys(entries).length) {
    process.exit(0);
  }

  let config = {
    mode: argv.mode ? argv.mode : "development",
    devtool: argv.mode ? false : "source-map",
    cache: argv.mode !== "production",
    stats: "errors-only",
    infrastructureLogging: {
      appendOnly: true,
      level: "log",
    },
    watchOptions: {
      poll: 1000,
    },
    entry: entries,
    module: {
      rules: [
        // Build Sass stylesheets.
        {
          test: /\.(sass|scss)$/,
          include: path.resolve(directory, "src/scss"),
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: "css-loader",
            },
            {
              loader: "postcss-loader",
              options: {
                postcssOptions: {
                  plugins: () => [autoprefixer],
                },
              },
            },
            {
              loader: "sass-loader",
              options: {
                sassOptions: {
                  importer: globSassImporter(),
                },
              },
            },
          ],
        },

        // Build JavaScript.
        {
          test: /\.(js|jsx)$/,
          include: path.resolve(directory, "src/js"),
          use: [
            {
              loader: "babel-loader",
              options: {
                presets: [["@babel/preset-env", { modules: "commonjs" }]],
                cacheDirectory: true,
              },
            },
          ],
        },

        // Build images.
        {
          test: /\.svg$/,
          include: path.resolve(directory, "src/images"),
          type: "asset/resource",
          use: [{ loader: "svgo-loader" }],
        },

        // Build icons sprite.
        {
          test: /\.svg$/,
          include: path.resolve(directory, "src/icons"),
          use: [
            {
              loader: "svg-sprite-loader",
              options: {
                extract: true,
                publicPath: "assets/",
                spriteFilename: "icons.svg",
              },
            },
            {
              loader: "svgo-loader",
            },
          ],
        },
      ],
    },
    optimization: {
      removeAvailableModules: false,
      minimizer: [new TerserPlugin({ extractComments: false })],
    },
    output: {
      path: path.resolve(directory, "public"),
      filename: "js/[name].js",
      assetModuleFilename: "assets/[name][ext][query]",
    },
    plugins: [
      new webpack.DefinePlugin({
        importAll: (resolve) => {
          resolve.keys().forEach(resolve);
        },
      }),
      new MiniCssExtractPlugin({ filename: "css/[name].css" }),
      new SpriteLoaderPlugin({ plainSprite: true }),
    ],
    externals: {
      jquery: "jQuery",
    },
  };

  // Merge package specific webpack configurations.
  if (path.basename(path.resolve(directory, "..")) === "components") {
    try {
      config = require(path.resolve(directory, "../../webpack.config.js"))(env, argv, config, __dirname);
    } catch (e) {}
  }
  try {
    config = require(path.resolve(directory, "webpack.config.js"))(env, argv, config, __dirname);
  } catch (error) {}

  return config;
};

module.exports = {
  multipass: true,
  plugins: [
    {
      name: "preset-default",
      params: {
        overrides: {
          // Retain viewBox (required for sizing in CSS content/background).
          // @see https://github.com/svg/svgo/issues/1128
          removeViewBox: false,
        },
      },
    },
    {
      // Remove width & height (required for sizing in CSS content/background).
      // @see https://github.com/svg/svgo/issues/1128
      name: "removeDimensions",
      active: true,
    },
    {
      // Remove stroke and fill attributes unless var() or url() value.
      name: "removeAttrs",
      params: {
        attrs: "*:(stroke|fill):((?!^var|url).)*",
      },
    },
  ],
};

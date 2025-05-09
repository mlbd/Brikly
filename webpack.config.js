const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    entry: {
        index: './src/Admin/index.js', // tell wp-scripts where your file is
    },
};
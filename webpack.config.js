const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    entry: {
        index: './assets/admin/settings/react/index.js', // tell wp-scripts where your file is
    },
};
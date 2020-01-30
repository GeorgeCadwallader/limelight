const c = require('@practically/webpack-4-config');
const path = require('path');

c.initialize({
    src_path: path.resolve(__dirname, 'assets', 'js'),
    dest_path: path.resolve(__dirname, 'web', 'assets'),
    entry_point: path.resolve(__dirname, 'assets', 'js', 'index.js'),
    public_path: '/assets/',
});

c.styles();

const config = c.build();

config.resolve.alias.vendor = path.resolve(__dirname, 'vendor');

module.exports = config;
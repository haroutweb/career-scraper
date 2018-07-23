const webpack = require('webpack');
const path = require('path');

module.exports = {
    mode: 'development',
    entry: [
        path.join(__dirname, 'public', 'js', 'app.js'),
    ],
    output: {
        path: path.join(__dirname, 'public', 'dist', 'js'),
        filename: 'bundle.js'
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin()
    ]
}
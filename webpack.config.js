const path = require( 'path' );
module.exports = {
    context: __dirname,
    entry: {
        fullcalendar: './js/fullcalendar.js'
    },
    output: {
        path: path.resolve( __dirname, 'webroot/js' ),
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: 'babel-loader',
            }
        ]
    }
};
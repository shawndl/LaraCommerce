module.exports = {
    module: {
        rules: [
            {
                test: /\.scss/,
                use: [
                    { loader: 'style-loader', options: { sourceMap: false } },
                    { loader: 'css-loader', options: { sourceMap: false } },
                    { loader: 'postcss-loader', options: { sourceMap: false} },
                    { loader: 'sass-loader', options: { sourceMap: false } },
                    { loader: 'vue-loader', options: {sourceMap: false}}
                ]
            }
        ]
    }
}
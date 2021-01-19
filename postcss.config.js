// if(process.env.NODE_ENV === 'production') {
    module.exports = {
        plugins: [
            require('autoprefixer'),
            require('cssnano'),
            // require('postcss-url-mapper')(function(url) {
            //     return url.replace(new RegExp('^/'), 'http://localhost:8888/');
            // })
            // More postCSS modules here if needed
        ]
    }
// }
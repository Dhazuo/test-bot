const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: {
                    '50': '#f9f3f3',
                    '100': '#f3e7e7',
                    '200': '#e2c2c2',
                    '300': '#d19d9d',
                    '400': '#ae5454',
                    '500': '#8b0b0a',
                    '600': '#7d0a09',
                    '700': '#680808',
                    '800': '#530706',
                    '900': '#440505'
                },
                logo: '#bb271d'
            },
            backgroundImage: {
                'chocolate': "url('/assets/bg.png')"
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};

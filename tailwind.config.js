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
                    '50': '#f2f6f8',
                    '100': '#e6edf1',
                    '200': '#bfd2db',
                    '300': '#99b7c5',
                    '400': '#4d809a',
                    '500': '#004a6f',
                    '600': '#004364',
                    '700': '#003853',
                    '800': '#002c43',
                    '900': '#002436'
                }
            },
            backgroundImage: {
                'main-background': "url('/assets/bg.png')",
                'stars': "url('/assets/estrellas.png')",
                'clouds-awards': "url('/assets/nubes_premios.png')",
                'cloud-contact-2': "url('/assets/seccion-contacto/nube_2_seccion_contacto.png')",
                'cloud-contact-3': "url('/assets/seccion-contacto/nube_3_seccion_contacto.png')",
                'cloud-how-to-participe': "url('/assets/seccion-como-participar/nubes_seccion_como_participar.png')"
            },
            inset: {
                'xl': '-17rem',
                'lg': '-12rem',
                'tablet': '-8rem',
                'mobile': '-4rem',

            },
            spacing: {
                'contact': '38rem',
                'contact-2': '-23rem',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};

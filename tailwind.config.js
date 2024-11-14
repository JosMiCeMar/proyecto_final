import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                handwrite: ['HandWriteFont', 'sans-serif'],
                monserrat: ['MonserratFont', 'sans-serif'],
                inter: ['InterFont', 'sans-serif']
            },
            colors: {
                'lavender-logo':'#BA7AD6',
                'skyblue-logo':'#68C3D6',
                'lavender-dark':'#3A2642',
                'skyblue-dark':'#315D66',
                'lavender-light':'#db99f7',
                'skyblue-light':'#87b3fa',
                'lavender-vlight':'#e3b8f5',
                'skyblue-vlight':'#bdd6ff',
                'lightyellow':'#FFFFFF',
                'almond':'#EBDCCB',
                'dun':'#C3BAAA'

            }
        },
    },

    plugins: [forms],
};

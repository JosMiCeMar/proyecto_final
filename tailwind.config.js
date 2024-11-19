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
                'lavender-light':'#DB99F7',
                'skyblue-light':'#87B3FA',
                'lavender-vlight':'#E3B8F5',
                'skyblue-vlight':'#BDD6FF',
                'lightyellow':'#F4FFFD'
            }
        },
    },

    plugins: [forms],
};

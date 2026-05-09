import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                parking: {
                    'primary-blue': '#003d7a',
                    'light-gray': '#c0c0c0',
                    'dark-gray': '#6b7b8b',
                    'panel-gray': '#d3d3d3',
                    'header-gray': '#b8b8b8',
                },
            },
        },
    },

    plugins: [forms],
};

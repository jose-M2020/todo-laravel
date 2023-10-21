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
            },
            colors: {
                'HOLDING': '#f7edb5',
                'IN PROGRESS': '#a0c7da',
                'FINISHED': '#9cfece',
            }
        },
    },

    plugins: [
        forms,
        require("daisyui")
    ],
    daisyui: {
        darkTheme: "light", // name of one of the included themes for dark mode
    },
};

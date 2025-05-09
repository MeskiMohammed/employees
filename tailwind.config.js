import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
// @ts-ignore
import daisyui from 'daisyui';

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
                    primary: {
                        50: '#FDF8EE', // Example: a very light shade
                        100: '#F9F0D9',
                        200: '#F3E5C0',
                        300: '#ECD9A6',
                        400: '#E5CD8D',
                        500: '#DAB540', // Your main color
                        600: '#C29D38',
                        700: '#A98530',
                        800: '#906D28',
                        900: '#775520', // Example: a very dark shade
                    },
                }
            },
        },

        daisyui: {
            themes: ["light", "dark"],
        },

        plugins: [forms,daisyui],
    };

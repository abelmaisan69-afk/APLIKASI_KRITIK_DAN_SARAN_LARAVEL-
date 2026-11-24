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
            sans: ['Poppins', 'sans-serif'],
        },
        colors: {
            primary: 'rgb(var(--c-primary) / <alpha-value>)',
            mint:    'rgb(var(--c-secondary) / <alpha-value>)',
            accent:  'rgb(var(--c-accent) / <alpha-value>)',
            ink:     '#1E293B',
           paper:   'rgb(var(--c-paper) / <alpha-value>)',
        },
    },
},
    plugins: [forms],
};

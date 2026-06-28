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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                slate: {
                    850: '#152033',
                },
                omni: {
                    dark: '#0F172A',
                    primary: '#1E3A8A',
                    success: '#10B981',
                    pending: '#F59E0B',
                    bg: '#F8FAFC',
                },
            },
        },
    },

    plugins: [forms],
};

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
            colors: {
                primary: '#1A1C1E',
                secondary: '#6C7278',
                tertiary: '#B8422E',
                neutral: '#F7F5F2',
                surface: '#FFFFFF',
            },
            fontFamily: {
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
                body: ['Public Sans', ...defaultTheme.fontFamily.sans],
                label: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                display: ['4rem', { lineHeight: '1.1', letterSpacing: '-0.02em' }],
                h1: ['1.75rem', { lineHeight: '1.3', letterSpacing: '-0.01em' }],
            },
            borderRadius: {
                sm: '2px',
                md: '4px',
                lg: '8px',
            },
            spacing: {
                sm: '8px',
                md: '16px',
                lg: '32px',
            },
        },
    },

    plugins: [forms],
};

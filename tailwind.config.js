import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/**/*.js',
        './resources/views/**/*.vue',
    ],

    safelist: [
        'from-primary',
        'to-primary/70',
        'to-primary/80',
        'to-primary/90',
        'to-primary/10',
        'to-primary/20',
        'to-primary/30',
        'to-primary/40',
        'to-primary/50',
        'to-primary/60',
        'hover:from-primary/90',
        'hover:to-primary',
        'hover:shadow-primary/20',
        'from-secondary',
        'to-secondary/10',
        'to-secondary/20',
        'to-secondary/30',
        'to-secondary/40',
        'to-secondary/50',
        'to-secondary/60',
        'to-secondary/70',
        'to-secondary/80',
        'to-secondary/90',
        'hover:from-secondary/90',
        'hover:to-secondary',
        'hover:shadow-secondary/20',
        'from-gray-400',
        'to-gray-400/70',
        'hover:from-gray-400/90',
        'hover:to-gray-400',
        'hover:shadow-gray-400/20',
        // tambahkan class lain yang Anda butuhkan
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#006D81',
                secondary: '#C08C52',
            },
            animation: {
                'gradient': 'gradient 3s ease infinite',
            },
            keyframes: {
                gradient: {
                    '0%, 100%': {
                        'background-size': '200% 200%',
                        'background-position': 'left center'
                    },
                    '50%': {
                        'background-size': '200% 200%',
                        'background-position': 'right center'
                    }
                }
            },
        },
    },

    plugins: [forms,
    ],
};

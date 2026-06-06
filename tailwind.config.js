import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Prompt', 'Kanit', ...defaultTheme.fontFamily.sans],
                prompt: ['Prompt', 'sans-serif'],
                kanit: ['Kanit', 'sans-serif'],
            },
            colors: {
                cafe: {
                    white:   '#FFFFFF',
                    cream:   '#F8F6F2',
                    beige:   '#E8E2D8',
                    tan:     '#C8B6A6',
                    green:   '#7D8F69',
                    'green-dark':  '#5a6b4a',
                    'green-light': '#a8c17b',
                    brown:   '#8B6F47',
                    'brown-dark':  '#5C4A32',
                },
            },
            animation: {
                'fade-in':    'fadeIn 0.8s ease both',
                'slide-up':   'slideUp 0.7s cubic-bezier(0.4,0,0.2,1) both',
                'scroll-x':   'scrollX 30s linear infinite',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4,0,0.6,1) infinite',
                'bounce-sm':  'bounceSm 2s ease-in-out infinite',
                'hero-pan':   'heroPan 20s ease-in-out infinite alternate',
                'loader-progress': 'loaderProg 1.8s ease forwards',
            },
            keyframes: {
                fadeIn:   { from: { opacity: '0', transform: 'translateY(20px)' }, to: { opacity: '1', transform: 'none' } },
                slideUp:  { from: { opacity: '0', transform: 'translateY(40px)' }, to: { opacity: '1', transform: 'none' } },
                scrollX:  { from: { transform: 'translateX(0)' }, to: { transform: 'translateX(-50%)' } },
                bounceSm: { '0%,100%': { transform: 'translateY(0)', opacity: '1' }, '50%': { transform: 'translateY(8px)', opacity: '0.6' } },
                heroPan:  { from: { transform: 'scale(1.06) translateX(-2%)' }, to: { transform: 'scale(1.06) translateX(2%)' } },
                loaderProg: { from: { width: '0%' }, to: { width: '100%' } },
            },
            backdropBlur: {
                xs: '2px',
            },
            boxShadow: {
                'green': '0 8px 32px rgba(125,143,105,0.28)',
                'cafe':  '0 20px 60px rgba(0,0,0,0.14)',
            },
            transitionTimingFunction: {
                'premium': 'cubic-bezier(0.4,0,0.2,1)',
            },
        },
    },

    plugins: [forms],
};

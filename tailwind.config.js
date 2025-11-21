import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './app/View/Components/**/*.php',
        './app/Livewire/**/*.php',

        './resources/**/*.{html,js,php}',

        './vendor/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],

    daisyui: {
        themes: ['light', 'dark'],
    },
}

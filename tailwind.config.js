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
                dm: ["DM Sans", "sans-serif"],
                mont: ["Montserrat", "sans-serif"],
                space: ["Space Grotesk", "sans-serif"],
                // tround: ['Tsukimi Rounded', 'sans-serif']
            },
            colors: {
                transparent: "transparent",
                current: "currentColor",
                seagreen: "#15B6A4",
                nblue: "#101827",
                lightblack: "#52525B",
                cream: "#EFEEEA"
            },
        },
    },
    plugins: [forms],
};

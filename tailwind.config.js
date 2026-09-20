/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                display: ['Bebas Neue', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },

    plugins: [],
};

const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/View/Components/**/*.php"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "SDSYuGothic", "Yu Gothic", "YuGothic", "sans-serif"
                  ],
            },
            colors: {
                'app-color': '#06010c',
                'line': '#06C755',
                'line-active': '#08a74a',
                'line-disabled': '#E5E5E5'
            },
        },
    },
};

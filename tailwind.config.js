import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Lato", ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                "pink-custom": "0px 0px 35px rgba(243, 26, 131, 1)",
                "pink-hard": "0px 2.5px 0px rgba(243, 26, 131, 0.5)",
                "black-custom": "0px 0px 15px rgba(0, 0, 0, 0.5)",
                "white-custom": "0px 0px 50px rgba(255, 255, 255, 1)",
            },
            colors: {
                gray: {
                    10: "rgba(255, 158, 207, 1)",
                },
                green: {
                    910: "#264226",
                },
                pink: {
                    650: "#F31A83",
                    450: "rgba(249, 181, 207, 0.42)",
                },
                gray: {
                    10: "rgba(0, 0, 0, 0.05)",
                    90: "#F7F6F9",
                    550: "#828486",
                },
                yellow: {
                    450: "#FFE500",
                    550: "#FF9F04",
                    650: "#F57D1F",
                },
            },
            borderColor: {
                gray: {
                    20: "rgba(0, 0, 0, 0.10)",
                },
            },
        },
    },
    plugins: [],
};

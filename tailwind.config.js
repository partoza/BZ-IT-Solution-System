/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#2F7D6D',
        dark: '#2B2B2B',
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'],
      },
      textColor: {
        DEFAULT: '#2B2B2B',
      },
    },
  },
  plugins: [],
}
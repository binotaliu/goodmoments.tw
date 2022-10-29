/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin')

const colors = require('./resources/js/colors.js')

module.exports = {
  content: [
    './vendor/spatie/laravel-support-bubble/config/**/*.php',
    './vendor/spatie/laravel-support-bubble/resources/views/**/*.blade.php',

    './resources/**/*.vue',
    './resources/**/*.js',
    './resources/**/*.ts',
    './resources/**/*.blade.php',
    './app/View/**/*.php',
  ],
  theme: {
    extend: {
      colors
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
    plugin(function ({ addVariant }) {
      addVariant('touch', '@media (pointer: coarse)')
    }),
    plugin(function ({ addVariant }) {
      addVariant('form-field-focus', '.form-field:focus-within &')
    })
  ],
}

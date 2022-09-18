/**
 * !!Attention!! This is not a real Tailwind config file.
 * This file exists so the Tailwind ESlint plugin can work.
 *
 * @type {import('tailwindcss').Config}
 * */
const plugin = require('tailwindcss/plugin')

const colors = require('./resources/js/colors.js')

module.exports = {
  content: [],
  theme: {
    extend: {
      colors
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    plugin(function ({ addVariant }) {
      addVariant('touch', '@media (pointer: coarse)')
    }),
    plugin(function ({ addVariant }) {
      addVariant('form-field-focus', '.form-field:focus-within &')
    })
  ],
}

/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
    './resources/**/*.vue',
    './resources/**/*.js',
    './resources/**/*.ts',
    './resources/**/*.blade.php',
    './app/View/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        gray: {
          100: '#d9d8d9',
          200: '#b4b2b2',
          300: '#8e8b8c',
          400: '#696565',
          500: '#433e3f',
          600: '#363232',
          700: '#282526',
          800: '#1b1919',
          900: '#0d0c0d',
        },
        blue: {
          100: '#d5dadc',
          200: '#acb5b9',
          300: '#828f96',
          400: '#596a73',
          500: '#2f4550',
          600: '#263740',
          700: '#1c2930',
          800: '#131c20',
          900: '#090e10',
        },
        pearl: {
          100: '#f6f5f4',
          200: '#edeae8',
          300: '#e4e0dd',
          400: '#dbd5d1',
          500: '#d2cbc6',
          600: '#a8a29e',
          700: '#7e7a77',
          800: '#54514f',
          900: '#2a2928',
        },
        sun: {
          100: '#f2e1d4',
          200: '#e4c2a9',
          300: '#d7a47d',
          400: '#c98552',
          500: '#bc6727',
          600: '#96521f',
          700: '#713e17',
          800: '#4b2910',
          900: '#261508',
        },
        cloud: {
          100: '#f2ecf1',
          200: '#e5d9e3',
          300: '#d7c5d4',
          400: '#cab2c6',
          500: '#bd9fb8',
          600: '#977f93',
          700: '#715f6e',
          800: '#4c404a',
          900: '#262025',
        },
        wood: {
          100: '#ebe8e2',
          200: '#d7d1c5',
          300: '#c3b9a8',
          400: '#afa28b',
          500: '#9b8b6e',
          600: '#7c6f58',
          700: '#5d5342',
          800: '#3e382c',
          900: '#1f1c16',
        },
        ground: {
          100: '#e4e3e0',
          200: '#cac7c1',
          300: '#afaaa3',
          400: '#958e84',
          500: '#7a7265',
          600: '#625b51',
          700: '#49443d',
          800: '#312e28',
          900: '#181714',
        },
      }
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

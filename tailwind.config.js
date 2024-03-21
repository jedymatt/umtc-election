import defaultTheme from 'tailwindcss/defaultTheme';
import plugin from 'tailwindcss/plugin';
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
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      'colors': {
        'primary': {
          DEFAULT: '#af2532',
          '50': '#fbf4f5',
          '100': '#f7e9eb',
          '200': '#ebc9cc',
          '300': '#dfa8ad',
          '400': '#c76670',
          '500': '#af2532',
          '600': '#9e212d',
          '700': '#831c26',
          '800': '#69161e',
          '900': '#561219',
        }
      },
    },
  },
  plugins: [
    forms,
    plugin(function ({ addVariant }) {
      addVariant('not-last', '&:not(:last-child)');
    }),
  ],
}


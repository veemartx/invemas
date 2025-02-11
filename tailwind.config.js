import containerQueries from '@tailwindcss/container-queries';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors');
const layerstack = require('@layerstack/tailwind/plugin');

import flowbitePlugin from 'flowbite/plugin'

export default {
  content: ['./src/**/*.{html,js,svelte,ts}', './node_modules/flowbite-svelte/**/*.{html,js,svelte,ts}'],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        invm_red: "#F22536ff",
        invm_green: "#60BF75ff",
        invm_jade: "#58AA6Aff",
        invm_pastel: "#2CB34Aff",
        invm_border: "#8080802b",
        invm_purple: "#5c4b9a",
        accent: colors.red,

        // transparent colors
        invm_tp_purple: "#9216926e",
        // flowbite-svelte
        primary: {
          50: '#FFF5F2',
          100: '#FFF1EE',
          200: '#FFE4DE',
          300: '#FFD5CC',
          400: '#FFBCAD',
          500: '#FE795D',
          600: '#EF562F',
          700: '#EB4F27',
          800: '#CC4522',
          900: '#A5371B'
        },
      }
    }
  },

  plugins: [typography, forms, containerQueries, flowbitePlugin]
};

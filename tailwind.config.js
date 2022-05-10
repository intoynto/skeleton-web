const twColors=require("tailwindcss/colors");
const { colors: defaultColors } = require('tailwindcss/lib/public/default-theme');
const stub=require("./tailw.plugin");

const pallets = {
  success: {
    50: "#e8f5e9",
    100: "#c8e6c9",
    200: "#a5d6a7",
    300: "#81c784",
    400: "#66bb6a",
    500: "#4caf50",
    600: "#43a047",
    700: "#388e3c",
    800: "#2e7d32",
    900: "#1b5e20",
  },
  danger: {
    50: "#ffebee",
    100: "#ffcdd2",
    200: "#ef9a9a",
    300: "#e57373",
    400: "#ef5350",
    500: "#f44336",
    600: "#e53935",
    700: "#d32f2f",
    800: "#c62828",
    900: "#b71c1c",
  }
};

module.exports = {
  mode:'jit',
  content: [
    './src/**/*.{js,ts,tsx}',
    './app/views/**/*.twig',
  ],
  theme: 
  {    
    /*
    fontSize: {
      xs: ['0.65rem', { lineHeight: '0.875rem' }],
      sm: ['0.75rem', { lineHeight: '0.975rem' }],
      base: ['0.875rem', { lineHeight: '1.2rem' }],
      '12': ['12px', { lineHeight: '1.1em' }],
      lg: ['1rem', { lineHeight: '1.5rem' }],
      xl: ['1.125rem', { lineHeight: '1.75rem' }],
      '2xl': ['1.25rem', { lineHeight: '1.75rem' }],
      '3xl': ['1.5rem', { lineHeight: '2rem' }],
      '4xl': ['1.875rem', { lineHeight: '2.25rem' }],
      '5xl': ['2.25rem', { lineHeight: '2.5rem' }],
      '6xl': ['3rem', { lineHeight: '1' }],
      '7xl': ['3.75rem', { lineHeight: '1' }],
      '8xl': ['4.5rem', { lineHeight: '1' }],
      '9xl': ['6rem', { lineHeight: '1' }],
      '10xl': ['8rem', { lineHeight: '1' }],
    },
    */
    extend: 
    {
        colors:{
          gray:twColors.slate,
          red:pallets.danger,
          yellow:twColors.amber,

          primary:twColors.indigo,
          secondary:twColors.slate,
          success:pallets.success,
          warning:twColors.amber,
          danger:pallets.danger,                       
        },
        screens: {
          'screen': { 'raw': 'screen' },
          'print': { 'raw': 'print' },
        },
        lineHeight: {
          '2': '0.5rem'
        },
        width:{
            'potrait':'21cm',
            'pos':'44mm',
        },
    },
  },

  variants:{
      extend:{
          translate:['active','group-hover'],
      }
  },

  plugins: [
    stub.exposeCssVar({ colors: ["gray", "primary","secondary","success", "warning", "danger"] })
  ],
}

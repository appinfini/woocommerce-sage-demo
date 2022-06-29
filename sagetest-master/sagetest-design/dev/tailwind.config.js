module.exports = {
  content: ["./public/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        'green' : {
          50:  '#00bc74',
        },
        'red' : {
          50:  '#db320d',
        },
        'slate' : {
          50:  '#f8f8f8',
        },
        'blue'  : {
          100: '#00567d',
          200: '#598ca2',
          300: '#d0e0eb',
        },
        'gray'  : {
          100: '#3c3c3c',
          200: '#6e6e6e',
          300: '#848484',
          400: '#ededed',
          500: '#c4c4c4',
        },
      },
      fontFamily: {
        'sans': ['"Inter"', 'sans-serif'],
      },
      width: {
        '21': '1.3125rem',
      },
      height: {
        '21': '1.3125rem',
      }
    },
  },
  corePlugins: {
    container: false
  },
  plugins: [
    require("@tailwindcss/forms"),
    function ({ addComponents }) {
      addComponents({
        '.container': {
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: '1rem',
          paddingRight: '1rem',
          maxWidth: '100%',
          '@screen sm': {
            maxWidth: '600px',
          },
          '@screen md': {
            maxWidth: '720px',
          },
          '@screen lg': {
            maxWidth: '980px',
          },
          '@screen xl': {
            maxWidth: '1230px',
          },
          '@screen 2xl': {
            maxWidth: '1440px',
          }
        }
      })
    },
  ],
}

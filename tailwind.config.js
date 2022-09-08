/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php"],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Montserrat', 'PT Sans'],
      },
      colors:{
        pared: '#e42312',
      },
    },
  },
  plugins: [],
}

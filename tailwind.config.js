/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    
  ],
  theme: {
    extend: { colors: {
      'main-blue':'#277BC0',
      'main-yellow':'#FFB200',
      'light-yellow':'#FFCB42',
      'dark-bold':'#313131',
      'dark-light':'#525252'
    },},
   
  },
  plugins: [],
}

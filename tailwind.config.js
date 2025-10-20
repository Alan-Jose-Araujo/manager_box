// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.{blade.php,js,css}',
    './node_modules/daisyui/dist/**/*.js', // Caso esteja usando o DaisyUI
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3b82f6',
        secondary: '#f43f5e',
        tertiary: '#34d399',
      },
    },
  },
  plugins: [
    require('daisyui'), // Se estiver usando o DaisyUI
  ],
}

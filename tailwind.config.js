/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        'rovuma': {
          'primary': '#003366',   // Azul escuro institucional
          'secondary': '#f39c12', // Amarelo/Ouro para detalhes
          'accent': '#005bb5',    // Azul claro para botões
          'light': '#f8fafc',     // Fundo cinza muito claro
        },
      },
      fontFamily: {
        'sans': ['Inter', 'sans-serif'], // Uma fonte mais moderna
      },
    },
  },
  plugins: [],
}


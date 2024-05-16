module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#E63946', // Couleur principale (rouge)
        secondary: '#464343', // Couleur secondaire (gris foncé)
        neutral: '#A5A5A5', // Couleur neutre (gris)
      },
    },
  },
  plugins: [],
};

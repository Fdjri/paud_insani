/** @type {import('tailwindcss').Config} */
export default {
  // Path ke file Blade/JS Anda
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  // Plugin DaisyUI harus ada di sini
  plugins: [
      require('daisyui'),
  ],
  // Konfigurasi tema DaisyUI
  daisyui: {
    themes: ["light"],
  },
}
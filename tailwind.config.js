/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Http/Controllers/**/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        primary: {
          50: 'rgb(240 245 255)',
          100: 'rgb(224 237 254)',
          200: 'rgb(199 221 252)',
          300: 'rgb(165 198 249)',
          400: 'rgb(125 164 244)',
          500: 'rgb(99 136 238)',
          600: 'rgb(79 108 228)',
          700: 'rgb(67 90 206)',
          800: 'rgb(56 75 167)',
          900: 'rgb(49 66 132)',
          950: 'rgb(30 41 82)',
        },
        secondary: {
          50: 'rgb(250 245 255)',
          100: 'rgb(243 232 255)',
          200: 'rgb(233 213 255)',
          300: 'rgb(216 180 254)',
          400: 'rgb(192 132 252)',
          500: 'rgb(168 85 247)',
          600: 'rgb(147 51 234)',
          700: 'rgb(126 34 206)',
          800: 'rgb(107 33 168)',
          900: 'rgb(88 28 135)',
          950: 'rgb(59 7 100)',
        },
        accent: {
          50: 'rgb(236 254 255)',
          100: 'rgb(207 250 254)',
          200: 'rgb(165 243 252)',
          300: 'rgb(103 232 249)',
          400: 'rgb(34 211 238)',
          500: 'rgb(6 182 212)',
          600: 'rgb(8 145 178)',
          700: 'rgb(14 116 144)',
          800: 'rgb(21 94 117)',
          900: 'rgb(22 78 99)',
          950: 'rgb(8 51 68)',
        },
      },
      keyframes: {
        fadeIn: {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        slideIn: {
          from: { opacity: '0', transform: 'translateX(-20px)' },
          to: { opacity: '1', transform: 'translateX(0)' },
        },
        'pulse-glow': {
          '0%, 100%': { boxShadow: '0 0 20px rgba(168, 85, 247, 0.4)' },
          '50%': { boxShadow: '0 0 40px rgba(168, 85, 247, 0.6)' },
        },
        blob: {
          '0%, 100%': { transform: 'translate(0px, 0px) scale(1)' },
          '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
          '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
        },
        gradient: {
          '0%, 100%': { backgroundPosition: '0% 50%' },
          '50%': { backgroundPosition: '100% 50%' },
        },
      },
      animation: {
        fadeIn: 'fadeIn 0.6s ease-out',
        slideIn: 'slideIn 0.6s ease-out',
        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
        blob: 'blob 7s infinite',
        gradient: 'gradient 3s ease infinite',
      },
    },
  },
  plugins: [],
}

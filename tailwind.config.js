/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php",
    "./assets/js/**/*.js",
  ],
  safelist: [
    "bg-pop-black/90",
    "max-h-[70vh]",
    "!border-0",
    "grid-cols-1",
    "grid-cols-2",
    "grid-cols-3",
    "sm:grid-cols-2",
    "lg:grid-cols-3",
    "bg-[#1877F2]",
    "bg-[#FF0000]",
    "bg-[#0A66C2]",
    "bg-[#E60023]",
    "bg-[#5865F2]",
    "bg-[#9146FF]",
    "bg-[#6364FF]",
  ],
  theme: {
    extend: {
      colors: {
        "pop-cyan": "#5CE1E6",
        "pop-yellow": "#FFDE59",
        "pop-pink": "#FF90E8",
        "pop-white": "#FFFFFF",
        "pop-black": "#000000",
        paper: "#F3F4F6",
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
        mono: ['"IBM Plex Mono"', "monospace"],
      },
      boxShadow: {
        "hard-sm": "4px 4px 0 0 #000",
        "hard-md": "8px 8px 0 0 #000",
        "hard-lg": "10px 10px 0 0 #000",
        "hard-xl": "16px 16px 0 0 #000",
      },
      borderWidth: {
        3: "3px",
      },
      keyframes: {
        marquee: {
          "0%": { transform: "translateX(0%)" },
          "100%": { transform: "translateX(-100%)" },
        },
      },
      animation: {
        marquee: "marquee 18s linear infinite",
        "marquee-slow": "marquee 28s linear infinite",
      },
    },
  },
  plugins: [],
};

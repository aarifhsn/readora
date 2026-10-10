/** @type {import('tailwindcss').Config} */
module.exports = {
  // ─── Content paths ────────────────────────────────────────────────────────
  // Tailwind scans these files and keeps only the classes that are actually used.
  content: ["./**/*.php", "./assets/js/**/*.js"],

  // ─── Dark mode ────────────────────────────────────────────────────────────
  // 'class' strategy: dark: variants activate when <html class="dark-mode"> is present.
  darkMode: ["class", ".dark-mode"],

  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#e63946",
          dark: "#c1121f",
          light: "#ff6b6b",
        },
        gray: {
          900: "#151514",
          800: "#2d2d2d",
          700: "#444444",
          600: "#66655f",
          500: "#6d6c66",
          400: "#aaaaaa",
          300: "#cccccc",
          200: "#e1ded7",
          100: "#f0eee9",
        },
        "text-primary": "var(--color-text-primary)",
        "text-secondary": "var(--color-text-secondary)",
        "text-muted": "var(--color-text-muted)",
        "border-base": "var(--color-border)",
        "bg-body": "var(--color-bg-body)",
        "bg-surface": "var(--color-bg-surface)",
        "bg-subtle": "var(--color-bg-subtle)",
      },

      fontFamily: {
        sans: [
          "Inter",
          "-apple-system",
          "BlinkMacSystemFont",
          "Segoe UI",
          "Roboto",
          "sans-serif",
        ],
        serif: ["Playfair Display", "Georgia", "Times New Roman", "serif"],
        mono: ["JetBrains Mono", "Fira Code", "Courier New", "monospace"],
      },

      maxWidth: {
        container: "1200px",
        content: "780px",
        sidebar: "320px",
      },

      transitionDuration: {
        fast: "150ms",
        base: "250ms",
        slow: "400ms",
      },

      zIndex: {
        header: "200",
        overlay: "100",
        modal: "300",
        raised: "10",
      },

      aspectRatio: {
        "16/9": "16 / 9",
        "16/7": "16 / 7",
      },
    },
  },

  plugins: [],
};

// eslint-disable-next-line import/no-unresolved -- vite has no main field, only exports
import { defineConfig } from 'vite';
import path from 'node:path';
import fs from 'fs';
import ejs from 'ejs';
import pkg from './package.json' with { type: 'json' };

export default defineConfig(({ mode }) => ({
  root: '.',
  publicDir: false,
  base: '',
  // https://vite.dev/config/server-options.html
  server: {
    // connection from Docker
    host: true,
    allowedHosts: [
      '.internal',
    ],
    port: 5173,
    strictPort: true,
    cors: true,
  },
  resolve: {
    alias: {
      // Map jquery import to global jQuery provided by WordPress
      jquery: path.resolve(__dirname, 'src/scripts/shims/jquery-global.js'),
    },
  },
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        loadPaths: [path.resolve(__dirname, 'src/styles')],
      },
    },
  },
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    assetsDir: '', // keep assets at dist root
    rolldownOptions: {
      input: {
        // JS entry (will emit dist/style.js) and its imported SCSS will emit dist/style.css
        style: path.resolve(__dirname, 'src/scripts/index.js'),
        // AmazonJS stylesheet (special output path handled in writeBundle hook)
        amazonjs: path.resolve(__dirname, 'src/styles/amazonjs.scss'),
      },
      output: {
        // Keep deterministic names without hashes for WP enqueue
        entryFileNames: '[name].js',
        assetFileNames: (info) => {
          const ext = path.extname(info.names[0]).slice(1);
          if (ext === 'css') return '[name].css';
          if (['ttf', 'eot', 'woff', 'woff2', 'svg'].includes(ext)) {
            return 'fonts/[name][extname]';
          }
          // images and others
          return 'assets/[name][extname]';
        },
        chunkFileNames: '[name].js',
      },
    },
    sourcemap: mode !== 'production',
    manifest: false,
  },
  plugins: [
    {
      name: 'move-amazonjs-and-generate-style-css',
      writeBundle: async () => {
        // Move dist/amazonjs.css to the project root as amazonjs.css
        const distCss = path.resolve(__dirname, 'dist/amazonjs.css');
        const rootCss = path.resolve(__dirname, 'amazonjs.css');
        try {
          if (fs.existsSync(distCss)) {
            fs.copyFileSync(distCss, rootCss);
            fs.unlinkSync(distCss);
          }
        } catch (e) {
          console.warn('[vite] Failed to relocate amazonjs.css:', e);
        }
        // Generate WordPress theme style.css from an EJS template
        try {
          const templatePath = path.resolve(__dirname, 'src/style.css.ejs');
          const buildNumber = (new Date()).getTime();
          const rendered = await ejs.renderFile(
            templatePath,
            {
              version: pkg.version,
              buildNumber,
            },
          );
          const outPath = path.resolve(__dirname, 'style.css');
          fs.writeFileSync(outPath, rendered);
        } catch (e) {
          console.warn('[vite] Failed to generate style.css:', e);
        }
      },
    },
  ],
}));

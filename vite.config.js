// eslint-disable-next-line import/no-extraneous-dependencies
import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import { exec } from 'child_process';

export default defineConfig(({ mode }) => ({
  root: '.',
  publicDir: false,
  base: '',
  // https://vite.dev/config/server-options.html
  server: {
    // connection from Docker
    host: true,
    allowedHosts: [
      '.internal'
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
  },
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    assetsDir: '', // keep assets at dist root
    rollupOptions: {
      input: {
        // JS entry (will emit dist/style.js) and its imported SCSS will emit dist/style.css
        style: path.resolve(__dirname, 'src/scripts/index.js'),
        // Separate editor stylesheet
        'style-editor': path.resolve(__dirname, 'src/styles/style-editor.scss'),
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
      name: 'move-amazonjs-and-run-themeinfo',
      writeBundle: async () => {
        // Move dist/amazonjs.css to project root as amazonjs.css
        const distCss = path.resolve(__dirname, 'dist/amazonjs.css');
        const rootCss = path.resolve(__dirname, 'amazonjs.css');
        try {
          if (fs.existsSync(distCss)) {
            fs.copyFileSync(distCss, rootCss);
            fs.unlinkSync(distCss);
          }
        } catch (e) {
          // eslint-disable-next-line no-console
          console.warn('[vite] Failed to relocate amazonjs.css:', e);
        }
        try {
          await new Promise((resolve) => {
            exec('node build/scripts/themeinfo.js', (err, stdout, stderr) => {
              if (stdout) process.stdout.write(stdout);
              if (stderr) process.stderr.write(stderr);
              resolve();
            });
          });
        } catch (e) {
          // eslint-disable-next-line no-console
          console.warn('[vite] themeinfo.js failed:', e);
        }
      },
    },
  ],
}));

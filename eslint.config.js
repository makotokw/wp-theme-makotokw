import { FlatCompat } from '@eslint/eslintrc';
import pluginImport from 'eslint-plugin-import';
import globals from 'globals';

const compat = new FlatCompat({ baseDirectory: process.cwd() });

export default [
  // Airbnb does not yet support ESLint9
  // https://github.com/airbnb/javascript/issues/2961
  // https://eslint.org/docs/latest/use/configure/migration-guide
  ...compat.extends('airbnb-base'),
  {
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
    },
    plugins: {
      import: pluginImport,
    },
  },
  // Browser-targeted source files
  {
    files: ['src/**/*.js'],
    languageOptions: {
      globals: {
        ...globals.browser,
        // jQuery globals (was env.jquery: true)
        $: 'readonly',
        jQuery: 'readonly',
        // Project specific globals
        makotokw: 'readonly',
        prettyPrint: 'readonly',
        FontAwesome: 'readonly',
      },
    },
    settings: {
      // Keep the resolver alias from the previous (Flat) config
      'import/resolver': {
        alias: {
          map: [['jquery', './src/scripts/shims/jquery-global.js']],
        },
      },
    },
    rules: {
      'func-names': ['error', 'never'],
      'class-methods-use-this': 'off',
    },
  },
  // Node-based tool
  {
    files: ['build/**/*.js', '*.config.js'],
    languageOptions: {
      globals: {
        ...globals.node,
      },
    },
    rules: {
      'import/no-extraneous-dependencies': ['error', { devDependencies: true }],
      'no-console': ['error', { allow: ['warn', 'error'] }],
    },
  },
];

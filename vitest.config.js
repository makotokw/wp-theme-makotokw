// eslint-disable-next-line import/no-unresolved -- vitest exposes config through package exports
import { defineConfig } from 'vitest/config';

// Test config is kept separate from vite.config.js so asset-build concerns
// and test concerns don't blur into one another.
export default defineConfig({
  test: {
    environment: 'happy-dom',
    include: ['tests/**/*.test.js'],
    // Require explicit imports of describe/it/expect to avoid implicit globals.
    globals: false,
  },
});

import assert from 'node:assert/strict';
import test from 'node:test';
import ScrollToTop from '../../src/scripts/components/scroll-to-top.js';

function createElement() {
  const classes = new Set();

  return {
    classes,
    classList: {
      toggle(className, force) {
        if (force) {
          classes.add(className);
        } else {
          classes.delete(className);
        }
      },
    },
  };
}

test('shows the control after scrolling beyond one viewport', () => {
  const element = createElement();
  globalThis.document = { getElementById: () => element };
  globalThis.window = { innerHeight: 800, scrollY: 801 };

  const scrollToTop = new ScrollToTop();
  scrollToTop.refresh();

  assert.equal(element.classes.has('is-visible'), true);
});

test('hides the control at or above the first viewport', () => {
  const element = createElement();
  element.classes.add('is-visible');
  globalThis.document = { getElementById: () => element };
  globalThis.window = { innerHeight: 800, scrollY: 800 };

  const scrollToTop = new ScrollToTop();
  scrollToTop.refresh();

  assert.equal(element.classes.has('is-visible'), false);
});

test('does nothing when the control is absent', () => {
  globalThis.document = { getElementById: () => null };
  globalThis.window = { innerHeight: 800, scrollY: 801 };

  const scrollToTop = new ScrollToTop();

  assert.doesNotThrow(() => scrollToTop.refresh());
});

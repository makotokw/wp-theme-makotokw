import assert from 'node:assert/strict';
import test from 'node:test';
import Header from '../../src/scripts/components/header.js';

function createElement(clientHeight = 85) {
  const classes = new Set();

  return {
    clientHeight,
    classes,
    classList: {
      add(className) {
        classes.add(className);
      },
      remove(className) {
        classes.delete(className);
      },
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

function createHeader({ clientHeight = 85, scrollY = 0 } = {}) {
  const siteHeader = createElement(clientHeight);
  const header = Object.create(Header.prototype);
  header.siteHeader = siteHeader;
  header.offset = clientHeight;
  header.lastScrollY = scrollY;
  globalThis.window = { scrollY };

  return { header, siteHeader };
}

test('unpins after scrolling down beyond the header', () => {
  const { header, siteHeader } = createHeader();
  window.scrollY = 86;

  header.refresh();

  assert.equal(siteHeader.classes.has('is-scrolled'), true);
  assert.equal(siteHeader.classes.has('is-unpinned'), true);
});

test('reveals the header when scrolling up', () => {
  const { header, siteHeader } = createHeader({ scrollY: 100 });
  siteHeader.classes.add('is-unpinned');
  window.scrollY = 90;

  header.refresh();

  assert.equal(siteHeader.classes.has('is-unpinned'), false);
});

test('keeps the visibility state when the scroll position is unchanged', () => {
  const { header, siteHeader } = createHeader({ scrollY: 100 });
  siteHeader.classes.add('is-unpinned');

  header.refresh();

  assert.equal(siteHeader.classes.has('is-unpinned'), true);
});

test('updates the offset on resize without changing the visibility state', () => {
  const { header, siteHeader } = createHeader({ clientHeight: 85, scrollY: 70 });
  siteHeader.classes.add('is-unpinned');
  siteHeader.clientHeight = 59;
  window.scrollY = 90;

  header.refresh({ byResize: true });

  assert.equal(header.offset, 59);
  assert.equal(siteHeader.classes.has('is-unpinned'), true);
});

test('syncs the scroll position when the navigation changes body positioning', () => {
  let clickHandler;
  const toggle = {
    addEventListener(eventName, handler) {
      if (eventName === 'click') {
        clickHandler = handler;
      }
    },
    classList: { toggle() {} },
  };
  const menu = { classList: { toggle() {} } };
  const header = Object.create(Header.prototype);
  header.lastScrollY = 500;
  header.stage = {
    toggleFixed() {
      window.scrollY = 0;
    },
  };
  globalThis.document = {
    getElementById: () => menu,
    querySelector: () => toggle,
  };
  globalThis.window = { scrollY: 500 };

  header.initNavigationMenu();
  clickHandler();

  assert.equal(header.lastScrollY, 0);
});

import {
  describe, it, expect, beforeEach, vi,
} from 'vitest';
import Header from '../../src/scripts/components/header.js';

// happy-dom does not compute layout, so clientHeight is always 0.
// Give the element an explicit height to exercise the scroll thresholds.
function createSiteHeader(clientHeight = 85) {
  const element = document.createElement('header');
  Object.defineProperty(element, 'clientHeight', {
    configurable: true,
    get() {
      return clientHeight;
    },
  });
  return element;
}

function createHeader({ clientHeight = 85, scrollY = 0 } = {}) {
  const siteHeader = createSiteHeader(clientHeight);
  const header = Object.create(Header.prototype);
  header.siteHeader = siteHeader;
  header.offset = clientHeight;
  header.lastScrollY = scrollY;
  window.scrollY = scrollY;

  return { header, siteHeader };
}

describe('Header', () => {
  beforeEach(() => {
    document.body.innerHTML = '';
    window.scrollY = 0;
  });

  it('unpins after scrolling down beyond the header', () => {
    const { header, siteHeader } = createHeader();
    window.scrollY = 86;

    header.refresh();

    expect(siteHeader.classList.contains('is-scrolled')).toBe(true);
    expect(siteHeader.classList.contains('is-unpinned')).toBe(true);
  });

  it('reveals the header when scrolling up', () => {
    const { header, siteHeader } = createHeader({ scrollY: 100 });
    siteHeader.classList.add('is-unpinned');
    window.scrollY = 90;

    header.refresh();

    expect(siteHeader.classList.contains('is-unpinned')).toBe(false);
  });

  it('keeps the visibility state when the scroll position is unchanged', () => {
    const { header, siteHeader } = createHeader({ scrollY: 100 });
    siteHeader.classList.add('is-unpinned');

    header.refresh();

    expect(siteHeader.classList.contains('is-unpinned')).toBe(true);
  });

  it('updates the offset on resize without changing the visibility state', () => {
    const { header, siteHeader } = createHeader({ clientHeight: 85, scrollY: 70 });
    siteHeader.classList.add('is-unpinned');
    Object.defineProperty(siteHeader, 'clientHeight', {
      configurable: true,
      get() {
        return 59;
      },
    });
    window.scrollY = 90;

    header.refresh({ byResize: true });

    expect(header.offset).toBe(59);
    expect(siteHeader.classList.contains('is-unpinned')).toBe(true);
  });

  it('syncs the scroll position when the navigation changes body positioning', () => {
    document.body.innerHTML = '<div id="menuOverlay"></div><button class="toggle"></button>';
    const header = Object.create(Header.prototype);
    header.lastScrollY = 500;
    header.stage = {
      toggleFixed: vi.fn(() => {
        // Pinning the body to the top resets the scroll offset.
        window.scrollY = 0;
      }),
    };
    window.scrollY = 500;

    header.initNavigationMenu();
    document.querySelector('.toggle').dispatchEvent(new Event('click'));

    expect(header.stage.toggleFixed).toHaveBeenCalledOnce();
    expect(header.lastScrollY).toBe(0);
  });
});

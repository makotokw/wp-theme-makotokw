import {
  describe, it, expect, beforeEach,
} from 'vitest';
import ScrollToTop from '../../src/scripts/components/scroll-to-top.js';

describe('ScrollToTop', () => {
  beforeEach(() => {
    // Reset the real DOM and scroll state between tests for isolation.
    document.body.innerHTML = '';
    window.scrollY = 0;
    window.innerHeight = 800;
  });

  it('shows the control after scrolling beyond one viewport', () => {
    document.body.innerHTML = '<div id="scrollToTop"></div>';
    window.scrollY = 801;

    const scrollToTop = new ScrollToTop();
    scrollToTop.refresh();

    const element = document.getElementById('scrollToTop');
    expect(element.classList.contains('is-visible')).toBe(true);
  });

  it('hides the control at or above the first viewport', () => {
    document.body.innerHTML = '<div id="scrollToTop" class="is-visible"></div>';
    window.scrollY = 800;

    const scrollToTop = new ScrollToTop();
    scrollToTop.refresh();

    const element = document.getElementById('scrollToTop');
    expect(element.classList.contains('is-visible')).toBe(false);
  });

  it('does nothing when the control is absent', () => {
    window.scrollY = 801;

    const scrollToTop = new ScrollToTop();

    expect(() => scrollToTop.refresh()).not.toThrow();
  });
});

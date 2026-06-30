import 'google-code-prettify/src/prettify';
import Header from './header';
import Content from './content';
import Footer from './footer';
import ProgressBar from './progress-bar';
import ScrollToTop from './scroll-to-top';

/**
 * Stage
 */
class Stage {
  constructor() {
    if (document.readyState !== 'loading') {
      this.init();
    } else {
      document.addEventListener('DOMContentLoaded', () => this.init());
    }
  }

  init() {
    this.header = new Header({ stage: this });
    this.content = new Content();
    this.footer = new Footer();
    this.progressBar = new ProgressBar();
    this.scrollToTop = new ScrollToTop();
    this.initFontAwesome();
    this.initViewportRefresh();
  }

  initFontAwesome() {
    // Prepend decorative icons to elements that PHP can't tag directly.
    // Class names are static, so injecting an <i> is safe and renders via the icon webfont.
    const icons = [
      { selector: '.enclosure-github', className: 'fab fa-github' },
      { selector: '.enclosure,.enclosure-qiita,.note-link', className: 'fas fa-bookmark' },
      { selector: '.enclosure-evernote', className: 'fab fa-evernote' },
      { selector: '.note-comment', className: 'fas fa-comment' },
    ];
    icons.forEach(({ selector, className }) => {
      this.prependFontAwesomeIcon(selector, className);
    });
  }

  prependFontAwesomeIcon(selector, className) {
    document.querySelectorAll(selector).forEach((element) => {
      element.insertAdjacentHTML('afterbegin', `<i class="${className}" aria-hidden="true"></i> `);
    });
  }

  initViewportRefresh() {
    window.addEventListener('scroll', () => {
      this.requestRefresh({ byScroll: true });
    });
    window.addEventListener('resize', () => {
      this.requestRefresh({ byResize: true });
    });
    this.requestRefresh({ byResize: true });
  }

  toggleFixed() {
    const { body } = document;

    if (body.classList.contains('is-fixed')) {
      body.classList.toggle('is-fixed');
      const { top } = document.body.style;
      body.style.position = '';
      body.style.top = '';
      window.scrollTo(0, parseInt(top || '0', 10) * -1);
    } else {
      const y = window.scrollY;
      document.body.style.position = 'fixed';
      document.body.style.top = `-${y}px`;
      body.classList.toggle('is-fixed');
    }
  }

  refresh({ byScroll, byResize }) {
    this.header.refresh({ byScroll, byResize });
    this.progressBar.refresh({ byScroll, byResize });
    this.scrollToTop.refresh();
    this.refreshing = false;
  }

  requestRefresh({ byScroll, byResize }) {
    if (!this.refreshing) {
      this.refreshing = true;
      if (window.requestAnimationFrame) {
        window.requestAnimationFrame(() => {
          this.refresh({ byScroll, byResize });
        });
      }
    }
  }
}

export default Stage;

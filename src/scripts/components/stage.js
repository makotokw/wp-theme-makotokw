import '@fortawesome/fontawesome-free/js/all';
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
    if (!window.FontAwesome) {
      return;
    }
    const icons = [
      { selector: '.enclosure-github', prefix: 'fab', iconName: 'github' },
      { selector: '.enclosure,.enclosure-qiita,.note-link', prefix: 'fas', iconName: 'bookmark' },
      { selector: '.enclosure-evernote', prefix: 'fab', iconName: 'evernote' },
      { selector: '.note-comment', prefix: 'fas', iconName: 'comment' },
    ];
    icons.forEach(({ selector, prefix, iconName }) => {
      this.prependFontAwesomeIcon(selector, prefix, iconName);
    });
  }

  prependFontAwesomeIcon(selector, prefix, iconName) {
    const { html } = window.FontAwesome.icon(
      window.FontAwesome.findIconDefinition({ prefix, iconName }),
    );
    document.querySelectorAll(selector).forEach((element) => {
      element.insertAdjacentHTML('afterbegin', html.join(''));
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

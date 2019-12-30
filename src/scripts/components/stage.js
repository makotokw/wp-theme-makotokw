// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import '@fortawesome/fontawesome-pro/js/all';
import 'google-code-prettify/src/prettify';
import SmoothScroll from 'smooth-scroll';
import Header from './header';
import Content from './content';
import Footer from './footer';
import ProgressBar from './progress-bar';

/**
 * Stage
 */
class Stage {
  constructor() {
    $(document).ready(() => {
      this.isAdmin = ($('#wpadminbar').length > 0);
      this.header = new Header({ stage: this });
      this.content = new Content({ isAdmin: this.isAdmin });
      this.footer = new Footer();
      this.progressBar = new ProgressBar();
      // noinspection JSUnusedGlobalSymbols
      this.smoothScrool = new SmoothScroll('a[href*="#"]', {
        speedAsDuration: true,
      });
      this.initFontAwesome();

      $(window)
        .scroll(() => {
          this.requestRefresh({ byScroll: true });
        })
        .resize(() => {
          this.requestRefresh({ byResize: true });
        });
      this.requestRefresh({ byResize: true });
    });
  }

  // eslint-disable-next-line
  initFontAwesome() {
    if (window.FontAwesome) {
      $('.enclosure-github').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fab', iconName: 'github' })).html,
        );
      });
      $('.enclosure,.enclosure-qiita,.note-link').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fas', iconName: 'bookmark' })).html,
        );
      });
      $('.enclosure-evernote').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fas', iconName: 'elephant' })).html,
        );
      });
      $('.note-comment').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fas', iconName: 'comment' })).html,
        );
      });
    }
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
    this.progressBar.refresh({ byScroll, byResize });
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

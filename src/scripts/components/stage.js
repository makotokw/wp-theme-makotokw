// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import '@fortawesome/fontawesome-pro/js/all';
import 'google-code-prettify/src/prettify';
import SmoothScroll from 'smooth-scroll';
import Header from './header';
import Content from './content';
import Footer from './footer';
import Sidebar from './sidebar';
import ProgressBar from './progress-bar';

class Stage {
  constructor() {
    $(document).ready(() => {
      this.isAdmin = ($('#wpadminbar').length > 0);
      this.header = new Header();
      this.content = new Content({ isAdmin: this.isAdmin });
      this.footer = new Footer();
      this.sidebar = new Sidebar();
      this.progressBar = new ProgressBar();
      // noinspection JSUnusedGlobalSymbols
      this.smoothScrool = new SmoothScroll('a[href*="#"]', {
        speedAsDuration: true,
      });
      this.obtainPageHeight();
      this.initFontAwesome();

      $(window)
        .scroll(() => {
          this.requestUpdate();
        })
        .resize(() => {
          this.obtainPageHeight();
          this.requestUpdate();
        });
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

  update() {
    this.updateProgressBar();
    this.updating = false;
  }

  updateProgressBar() {
    this.progressBar.max = this.lastDocumentHeight - this.lastWindowHeight;
    this.progressBar.val = window.scrollY;
  }

  requestUpdate() {
    if (!this.updating) {
      this.updating = true;
      if (window.requestAnimationFrame) {
        window.requestAnimationFrame(() => {
          this.update();
        });
      }
    }
  }

  obtainPageHeight() {
    this.lastWindowHeight = $(window).height();
    this.lastDocumentHeight = $(document.body).height();
  }
}

export default Stage;

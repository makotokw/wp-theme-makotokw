// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import 'headroom.js/dist/headroom';
import 'headroom.js/dist/jQuery.headroom';

class Header {
  /**
   * @param {Stage} stage
   */
  constructor({ stage }) {
    this.stage = stage;
    this.initSticky();
    this.initNavigationMenu();
  }

  initSticky() {
    const $header = $('#siteHeader');
    $header.headroom({
      offset: $header.height(),
    });
  }

  initNavigationMenu() {
    const menu = document.getElementById('menuOverlay');
    if (!menu) {
      return;
    }
    const toggle = document.querySelector('.nav-toggle');
    if (toggle) {
      toggle.addEventListener('click', () => {
        this.stage.toggleFixed();
        menu.classList.toggle('is-hidden');
        toggle.classList.toggle('is-pressed');
      });
    }
  }
}

export default Header;

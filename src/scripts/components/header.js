import Headroom from 'headroom.js/dist/headroom';

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
    const siteHeader = document.getElementById('siteHeader');
    this.headroom = new Headroom(siteHeader, {
      offset: siteHeader.clientHeight,
    });
    this.headroom.init();
  }

  initNavigationMenu() {
    const menu = document.getElementById('menuOverlay');
    if (!menu) {
      return;
    }
    const toggle = document.querySelector('.toggle');
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

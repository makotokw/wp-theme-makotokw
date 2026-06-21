class Header {
  /**
   * @param {Stage} stage
   */
  constructor({ stage }) {
    this.stage = stage;
    this.siteHeader = document.getElementById('siteHeader');
    this.lastScrollY = window.scrollY;
    this.initScrollState();
    this.initNavigationMenu();
  }

  initScrollState() {
    if (!this.siteHeader) {
      return;
    }
    this.offset = this.siteHeader.clientHeight;
    this.refresh();
  }

  refresh({ byResize } = {}) {
    if (!this.siteHeader) {
      return;
    }
    if (byResize) {
      this.offset = this.siteHeader.clientHeight;
    }
    const currentY = window.scrollY;
    this.siteHeader.classList.toggle('is-scrolled', currentY > this.offset);

    if (!byResize && currentY < this.lastScrollY) {
      this.siteHeader.classList.remove('is-unpinned');
    } else if (!byResize && currentY > this.lastScrollY && currentY > this.offset) {
      this.siteHeader.classList.add('is-unpinned');
    }

    this.lastScrollY = currentY;
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
        this.lastScrollY = window.scrollY;
        menu.classList.toggle('is-hidden');
        toggle.classList.toggle('is-pressed');
      });
    }
  }
}

export default Header;

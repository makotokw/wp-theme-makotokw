import Slideout from 'slideout';

class Sidebar {
  constructor() {
    const panel = document.getElementById('siteContent');
    const menu = document.getElementById('sideBar');

    if (!panel || !menu) {
      return;
    }

    this.slideout = new Slideout({
      panel: document.getElementById('siteContent'),
      menu: document.getElementById('sideBar'),
      padding: 0,
      tolerance: 70,
    });

    const toggle = document.querySelector('.nav-toggle');
    if (toggle) {
      toggle.addEventListener('click', () => {
        this.slideout.toggle();
        toggle.classList.toggle('toggle__show');
      });
    }
  }
}

export default Sidebar;

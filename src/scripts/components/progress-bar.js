class ProgressBar {
  constructor() {
    this.element = document.getElementById('siteProgress');
  }

  set max(value) {
    if (this.element) {
      this.element.max = value;
    }
  }

  set val(value) {
    if (this.element) {
      this.element.value = value;
    }
  }

  refresh({ byResize }) {
    if (byResize) {
      this.max = document.body.clientHeight - window.innerHeight;
    }
    this.val = window.scrollY;
  }
}

export default ProgressBar;

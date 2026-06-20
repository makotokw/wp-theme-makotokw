class ScrollToTop {
  constructor() {
    this.element = document.getElementById('scrollToTop');
  }

  refresh() {
    if (!this.element) {
      return;
    }

    this.element.classList.toggle('is-visible', window.scrollY > window.innerHeight);
  }
}

export default ScrollToTop;

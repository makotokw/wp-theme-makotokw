// noinspection NpmUsedModulesInstalled
import $ from 'jquery';

class ProgressBar {
  constructor() {
    this.$siteProgress = $('#siteProgress');
  }

  set max(value) {
    this.$siteProgress.attr('max', value);
  }

  set val(value) {
    this.$siteProgress.val(value);
  }

  refresh({ byResize }) {
    if (byResize) {
      this.max = document.body.clientHeight - window.innerHeight;
    }
    this.val = window.scrollY;
  }
}

export default ProgressBar;

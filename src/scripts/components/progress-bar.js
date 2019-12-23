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
}

export default ProgressBar;

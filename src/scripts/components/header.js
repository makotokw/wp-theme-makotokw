// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import 'headroom.js/dist/headroom';
import 'headroom.js/dist/jQuery.headroom';

class Header {
  constructor() {
    const $header = $('#siteHeader');
    $header.headroom({
      offset: $header.height(),
    });
  }
}

export default Header;

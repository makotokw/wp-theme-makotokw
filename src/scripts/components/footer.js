// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import 'headroom.js/dist/headroom';
import 'headroom.js/dist/jQuery.headroom';

class Footer {
  constructor() {
    $('#toTheTop').headroom();
  }
}

export default Footer;

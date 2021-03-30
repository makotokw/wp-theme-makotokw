// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import { Notyf } from 'notyf';
import tippy from 'tippy.js';
import Clipboard from 'clipboard';
import 'google-code-prettify/src/prettify';
import lazyLoadShareCount from '../utils/lazy-load-share-count';

class Content {
  constructor({ isAdmin }) {
    if (typeof prettyPrint === 'function') {
      prettyPrint();
    }

    if (isAdmin) {
      lazyLoadShareCount(true);
    }
    const $jetPackRelatedPosts = $('#jp-relatedposts');
    const $shareThis = $('#shareThis');
    if ($shareThis.length > 0) {
      $jetPackRelatedPosts.insertBefore($shareThis);
    }
    const notyf = new Notyf({
      position: { x: 'right', y: 'bottom' },
      types: [
        {
          type: 'success',
          background: '#4db5d7',
        },
      ],
    });
    const clipboard = new Clipboard('.btn-share-url');
    clipboard.on('success', (e) => {
      notyf.success(e.trigger.getAttribute('data-toast-success'));
    });

    tippy('[data-tippy-content]', {
      theme: 'makotokw',
    });
  }
}

export default Content;

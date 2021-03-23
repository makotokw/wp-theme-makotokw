// noinspection NpmUsedModulesInstalled
import $ from 'jquery';
import tippy from 'tippy.js';
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

    tippy('[data-tippy-content]', {
      theme: 'makotokw',
    });
  }
}

export default Content;

// noinspection NpmUsedModulesInstalled
import jquery from 'jquery';
import { Notyf } from 'notyf';
import tippy from 'tippy.js';
import 'google-code-prettify/src/prettify';
import lazyLoadShareCount from '../utils/lazy-load-share-count';

const $ = jquery;

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
    document.querySelectorAll('.btn-share-url').forEach((button) => {
      button.addEventListener('click', async () => {
        const text = button.dataset.clipboardText;
        try {
          if (!text || !navigator.clipboard) {
            throw new Error('Clipboard is unavailable.');
          }
          await navigator.clipboard.writeText(text);
          notyf.success(button.dataset.toastSuccess);
        } catch {
          notyf.error(button.dataset.toastError);
        }
      });
    });

    tippy('[data-tippy-content]', {
      theme: 'makotokw',
    });
  }
}

export default Content;

import $ from 'jquery';
import 'google-code-prettify/src/prettify';
import SmoothScroll from 'smooth-scroll';
import 'headroom.js/dist/headroom';
import 'headroom.js/dist/jQuery.headroom';
import lazyLoadShareCount from './lazy-load-share-count';

let isAdmin = false;

$(document).ready(() => {
  if (typeof prettyPrint === 'function') {
    prettyPrint();
  }

  const $siteProgress = $('#siteProgress');
  let lastWindowHeight = 0;
  let lastDocumentHeight = 0;
  let updating = false;

  // eslint-disable-next-line no-new
  new SmoothScroll('a[href*="#"]', {
    speedAsDuration: true,
  });

  function initHeader() {
    const $searchForm = $('#siteHeaderSearchForm');
    $('#siteHeaderSearchTrigger').on('click', () => {
      $searchForm.toggleClass('is-active');
      if ($searchForm.hasClass('is-active')) {
        $('#siteHeaderSearchText').focus();
      }
    });
  }

  function updateProgressBar() {
    const progressMax = lastDocumentHeight - lastWindowHeight;
    $siteProgress.attr('max', progressMax);
    $siteProgress.val(window.scrollY);
  }

  function update() {
    updateProgressBar();
    updating = false;
  }

  function cacheLastWindowSize() {
    lastWindowHeight = $(window).height();
    lastDocumentHeight = $(document.body).height();
  }

  function requestUpdate() {
    if (!updating) {
      updating = true;
      if (window.requestAnimationFrame) {
        requestAnimationFrame(update);
      }
    }
  }

  function onScroll() {
    requestUpdate();
  }

  function onResize() {
    cacheLastWindowSize();
    requestUpdate();
  }

  cacheLastWindowSize();
  initHeader();

  $(window)
    .scroll(onScroll)
    .resize(onResize);

  isAdmin = ($('#wpadminbar').length > 0);
  const $header = $('#siteHeader');
  $header.headroom({
    offset: $header.height(),
  });
  $('#toTheTop').headroom();

  if (isAdmin) {
    lazyLoadShareCount(true);
  }

  const $jetPackRelatedPosts = $('#jp-relatedposts');
  const $shareThis = $('#shareThis');
  if ($shareThis.length > 0) {
    $jetPackRelatedPosts.insertBefore($shareThis);
  }

  // TODO: FontAwesome js
  if (window.FontAwesome) {
    $('.enclosure-github').each(function () {
      $(this).prepend(
        FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fab', iconName: 'github-alt' })).html,
      );
    });
    $('.enclosure,.enclosure-qiita,.enclosure-qiita,.note-link').each(function () {
      $(this).prepend(
        FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fas', iconName: 'bookmark' })).html,
      );
    });
    $('.note-comment').each(function () {
      $(this).prepend(
        FontAwesome.icon(FontAwesome.findIconDefinition({ prefix: 'fas', iconName: 'comment' })).html,
      );
    });
  }
});

import 'google-code-prettify/src/prettify';
import 'headroom.js/dist/headroom';
import 'headroom.js/dist/jQuery.headroom';

const $ = jQuery;

let isAdmin = false;
let enabledShareCounter = false;

function updateShareCount() {
  const $shareThis = $('#shareThis');
  const permalink = $shareThis.data('url');
  const encodedPermalink = encodeURIComponent(permalink);

  function toInt(num) {
    const i = parseInt(num, 10);
    return (Number.isNaN(i)) ? 0 : i;
  }

  function createCountElement(shareCount) {
    const count = toInt(shareCount);
    const $c = $('<span/>').addClass('share-count').text(count);
    if (count > 0) {
      $c.addClass('share-count-has');
    }
    return $c;
  }

  if (enabledShareCounter) {
    // http://developer.hatena.ne.jp/ja/documents/bookmark/apis/getcount
    $.ajax({ url: `https://b.hatena.ne.jp/entry.count?url=${encodedPermalink}`, dataType: 'jsonp' })
      .done((data) => {
        $shareThis.find('.share-hatena .btn').append(createCountElement(data));
      });
    $.ajax({ url: `https://graph.facebook.com/?id=${encodedPermalink}`, dataType: 'jsonp' })
      .done((data) => {
        if (data) {
          $shareThis.find('.share-facebook .btn').append(createCountElement(data.shares));
        }
      });

    if (makotokw && makotokw.counter_api && makotokw.counter_api.length > 0) {
      $.ajax({ url: `${makotokw.counter_api}?url=${encodedPermalink}`, dataType: 'jsonp' })
        .done((data) => {
          if (!data) {
            return;
          }
          $shareThis.find('.share-pocket .btn').append(createCountElement(data.pocket));
          $shareThis.find('.share-googleplus .btn').append(createCountElement(data.google));
        });
    }
  }
}

function lazyLoadShareCount() {
  const $shareThis = $('#shareThis');
  if ($shareThis.length > 0) {
    $(window).bind('scroll.shareThis load.shareThis', function () {
      if ($(this).scrollTop() + $(this).height() > $shareThis.offset().top) {
        updateShareCount();
        $(this).unbind('scroll.shareThis load.shareThis');
      }
    });
  }
}

const $footerMargin = $('#footerMargin');

$(document).ready(() => {
  if (typeof prettyPrint === 'function') {
    prettyPrint();
  }

  const $siteProgress = $('#siteProgress');
  let lastWindowHeight = 0;
  let lastDocumentHeight = 0;
  let updating = false;

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

  function stickyFooter() {
    const windowHeight = $(window).height();
    const docHeight = lastDocumentHeight - $footerMargin.height();
    let diff = windowHeight - docHeight;
    if (isAdmin) {
      diff -= 32;
    }
    if (diff <= 0) {
      $footerMargin.hide();
      $footerMargin.height(1);
    } else {
      $footerMargin.show();
      $footerMargin.height(diff);
    }
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
    stickyFooter();
    requestUpdate();
  }

  function onResize() {
    cacheLastWindowSize();
    stickyFooter();
    requestUpdate();
  }

  cacheLastWindowSize();
  initHeader();

  $(window)
    .on('sticky', stickyFooter)
    .scroll(onScroll)
    .resize(onResize);

  isAdmin = ($('#wpadminbar').length > 0);
  const $header = $('#siteHeader');
  $header.headroom({
    offset: $header.height(),
  });

  enabledShareCounter = isAdmin;
  if (enabledShareCounter) {
    lazyLoadShareCount();
  }
  stickyFooter();

  const $jetPackRelatedPosts = $('#jp-relatedposts'); const
    $shareThis = $('#shareThis');
  if ($shareThis.length > 0) {
    $jetPackRelatedPosts.insertBefore($shareThis);
  }

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

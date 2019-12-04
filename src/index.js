/*global makotokw, jQuery*/
(function ($) {
  var isAdmin = false;
  var enabledShareCounter = false;

  function updateShareCount() {
    var $shareThis = $('#shareThis');
    var permalink = $shareThis.data('url'), encodedPermalink = encodeURIComponent(permalink);

    function toInt(num) {
      var i = parseInt(num);
      return (isNaN(i)) ? 0 : i;
    }

    function createCountElement(shareCount) {
      shareCount = toInt(shareCount);
      var $c = $('<span/>').addClass('share-count').text(shareCount);
      if (shareCount > 0) {
        $c.addClass('share-count-has');
      }
      return $c;
    }

    if (enabledShareCounter) {
      // http://developer.hatena.ne.jp/ja/documents/bookmark/apis/getcount
      $.ajax({url: 'https://b.hatena.ne.jp/entry.count?url=' + encodedPermalink, dataType: 'jsonp'})
        .done(function (data) {
          $shareThis.find('.share-hatena .btn').append(createCountElement(data));
        });
      $.ajax({url: 'https://graph.facebook.com/?id=' + encodedPermalink, dataType: 'jsonp'})
        .done(function (data) {
          if (data) {
            $shareThis.find('.share-facebook .btn').append(createCountElement(data.shares));
          }
        });

      if (makotokw && makotokw.counter_api && makotokw.counter_api.length > 0) {
        $.ajax({url: makotokw.counter_api + '?url=' + encodedPermalink, dataType: 'jsonp'})
          .done(function (data) {
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
    var $shareThis = $('#shareThis');
    if ($shareThis.length > 0) {
      $(window).bind('scroll.shareThis load.shareThis', function () {
        if ($(this).scrollTop() + $(this).height() > $shareThis.offset().top) {
          updateShareCount();
          $(this).unbind('scroll.shareThis load.shareThis');
        }
      });
    }
  }

  var $footerMargin = $('#footerMargin');

  $(document).ready(function () {
    if (typeof prettyPrint === "function") {
      prettyPrint();
    }

    var $siteProgress = $('#siteProgress');
    var lastWindowHeight = 0,
      lastDocumentHeight = 0;
    var updating = false;

    cacheLastWindowSize();
    initHeader();

    $(window)
      .on('sticky', stickyFooter)
      .scroll(onScroll)
      .resize(onResize);

    function initHeader() {
      var $searchForm = $('#siteHeaderSearchForm');
      $('#siteHeaderSearchTrigger').on('click', function(){
        $searchForm.toggleClass('is-active');
        if ($searchForm.hasClass('is-active')) {
          $('#siteHeaderSearchText').focus();
        }
      });
    }

    function updateProgressBar() {
      var progressMax = lastDocumentHeight - lastWindowHeight;
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

    function onScroll() {
      stickyFooter();
      requestUpdate();
    }

    function onResize() {
      cacheLastWindowSize();
      stickyFooter();
      requestUpdate();
    }

    function stickyFooter() {
      var windowHeight = $(window).height();
      var docHeight = lastDocumentHeight - $footerMargin.height();
      var diff = windowHeight - docHeight;
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
        if (Modernizr.requestanimationframe) {
          requestAnimationFrame(update);
        }
      }
    }

    isAdmin = ($('#wpadminbar').length > 0);
    var $header = $('#siteHeader');
    $header.headroom({
      offset: $header.height()
    });

    enabledShareCounter = isAdmin;
    if (enabledShareCounter) {
      lazyLoadShareCount();
    }
    stickyFooter();

    var $jetPackRelatedPosts = $('#jp-relatedposts'), $shareThis = $('#shareThis');
    if ($shareThis.length > 0) {
      $jetPackRelatedPosts.insertBefore($shareThis);
    }

    if (window.FontAwesome) {
      $('.enclosure-github').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({prefix: 'fab', iconName: 'github-alt'})).html
        );
      });
      $('.enclosure,.enclosure-qiita,.enclosure-qiita,.note-link').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({prefix: 'fas', iconName: 'bookmark'})).html
        );
      });
      $('.note-comment').each(function () {
        $(this).prepend(
          FontAwesome.icon(FontAwesome.findIconDefinition({prefix: 'fas', iconName: 'comment'})).html
        );
      });
    }
  });

})(jQuery);

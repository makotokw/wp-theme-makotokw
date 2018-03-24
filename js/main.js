/*global makotokw, jQuery*/
(function ($) {
  var isAdmin = false;

  function updateShareCount() {
    var $shareThis = $('#shareThis');
    var permalink = $shareThis.data('url'), encodedPermalink = encodeURIComponent(permalink);

    function toInt(num) {
      var i = parseInt(num);
      return (isNaN(i)) ? 0 : i;
    }

    if (isAdmin) {
      // http://developer.hatena.ne.jp/ja/documents/bookmark/apis/getcount
      $.ajax({url: 'http://api.b.st-hatena.com/entry.count?url=' + encodedPermalink, dataType: 'jsonp'})
        .done(function (data) {
          var $count = $('<span/>').addClass('share-count').text(toInt(data));
          $shareThis.find('.share-hatena .btn').append($count);
        });
      $.ajax({url: 'https://graph.facebook.com/?id=' + encodedPermalink, dataType: 'jsonp'})
        .done(function (data) {
          if (data) {
            var $count = $('<span/>').addClass('share-count').text(toInt(data.shares));
            $shareThis.find('.share-facebook .btn').append($count);
          }
        });

      if (makotokw && makotokw.counter_api && makotokw.counter_api.length > 0) {
        $.ajax({url: makotokw.counter_api + '?url=' + encodedPermalink, dataType: 'jsonp'})
          .done(function (data) {
            if (!data) return;
            var $countPocket = $('<span/>').addClass('share-count').text(toInt(data.pocket));
            $shareThis.find('.share-pocket .btn').append($countPocket);
            var $countGooglePlus = $('<span/>').addClass('share-count').text(toInt(data.google));
            $shareThis.find('.share-googleplus .btn').append($countGooglePlus);
          });
      }

    }
  }

  function lazyLoadShareCount() {
    var $shareThis = $('#shareThis');
    if ($shareThis.length > 0 && isAdmin) {
      $(window).bind('scroll.shareThis load.shareThis', function () {
        if ($(this).scrollTop() + $(this).height() > $shareThis.offset().top) {
          updateShareCount();
          $(this).unbind('scroll.shareThis load.shareThis');
        }
      });
    }
  }

  var $footerMargin = $('#footerMargin');

  // $('#siteLogo').each(function () {
  //   var $img = $(this);
  //   if (Modernizr.svg) {
  //     var id = $img.attr('id'),
  //       cls = $img.attr('class');
  //
  //     $.get($img.attr('src'), function (data) {
  //       var $svg = $(data).find('svg');
  //       if (typeof id !== 'undefined') {
  //         $svg.attr('id', id);
  //       }
  //       if (typeof cls !== 'undefined') {
  //         $svg.attr('class', cls + ' replaced-svg');
  //       }
  //       // Remove any invalid XML tags as per https://validator.w3.org/
  //       $svg = $svg.removeAttr('xmlns:a');
  //       $img.replaceWith($svg);
  //     }, 'xml');
  //   } else {
  //     $img.attr('src', $img.attr('src').replace(/\.svg/gi, '.png'));
  //   }
  // });

  $(document).ready(function () {
    if ($.isFunction(prettyPrint)) {
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
        diff = 1;
      }
      $footerMargin.height(diff);
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
    $('#siteHeader').headroom();
    // avoid seeing ShareCount
    //lazyLoadShareCount();
    stickyFooter();

    $('#jp-relatedposts').insertBefore($('#shareThis'));

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

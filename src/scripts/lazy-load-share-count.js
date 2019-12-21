import $ from 'jquery';

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

function updateShareCount(isAdmin) {
  const $shareThis = $('#shareThis');
  const permalink = $shareThis.data('url');
  const encodedPermalink = encodeURIComponent(permalink);

  if (isAdmin) {
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

function lazyLoadShareCount(isAdmin) {
  const $shareThis = $('#shareThis');
  if ($shareThis.length > 0) {
    $(window).bind('scroll.shareThis load.shareThis', function () {
      if ($(this).scrollTop() + $(this).height() > $shareThis.offset().top) {
        updateShareCount(isAdmin);
        $(this).unbind('scroll.shareThis load.shareThis');
      }
    });
  }
}

export default lazyLoadShareCount;

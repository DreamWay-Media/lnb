(function ($) {
  'use strict';

  if (typeof dwmBlogArchive === 'undefined') {
    return;
  }

  var $wrap = $('#blog-archive-results');
  var $pag = $('#blog-archive-pagination');
  var $toolbar = $('.blog-archive__toolbar');
  if (!$wrap.length) {
    return;
  }

  var currentCat = 0;
  var currentSearch = '';
  var currentPage = 1;
  var searchTimer = null;

  function setLoading(on) {
    $wrap.closest('.blog-archive__list').toggleClass('is-loading', on);
  }

  function fetchPosts(paged) {
    paged = paged || 1;
    currentPage = paged;
    setLoading(true);
    $.post(
      dwmBlogArchive.ajaxUrl,
      {
        action: 'dwm_lnb_filter_posts',
        nonce: dwmBlogArchive.nonce,
        cat: currentCat,
        search: currentSearch,
        paged: paged
      }
    )
      .done(function (res) {
        if (!res || !res.success) {
          return;
        }
        var d = res.data;
        $wrap.html(d.html || '');
        if ($pag.length) {
          $pag.html(d.pagination || '');
        }
      })
      .always(function () {
        setLoading(false);
      });
  }

  $toolbar.on('click', '.blog-archive__cat-btn', function (e) {
    e.preventDefault();
    var $btn = $(this);
    var cat = parseInt($btn.data('cat'), 10) || 0;
    currentCat = cat;
    $toolbar.find('.blog-archive__cat-btn').removeClass('is-active');
    $btn.addClass('is-active');
    fetchPosts(1);
  });

  $toolbar.on('submit', '.blog-archive__search-form', function (e) {
    e.preventDefault();
    currentSearch = $(this).find('.blog-archive__search-input').val() || '';
    fetchPosts(1);
  });

  $toolbar.on('input', '.blog-archive__search-input', function () {
    var v = $(this).val() || '';
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function () {
      currentSearch = v;
      fetchPosts(1);
    }, 420);
  });

  $(document).on('click', '#blog-archive-pagination a.page-numbers', function (e) {
    e.preventDefault();
    var $a = $(this);
    if ($a.hasClass('dots')) {
      return;
    }
    var p = parseInt($a.attr('data-page'), 10);
    if (!p || isNaN(p)) {
      var href = $a.attr('href') || '';
      var m = href.match(/[?&]paged=(\d+)/) || href.match(/\/page\/(\d+)/);
      p = m ? parseInt(m[1], 10) : 1;
      if ($a.hasClass('prev')) {
        p = Math.max(1, currentPage - 1);
      } else if ($a.hasClass('next')) {
        p = currentPage + 1;
      }
    }
    fetchPosts(p);
    var $main = $('#blog-archive');
    if ($main.length) {
      $('html, body').animate({ scrollTop: $main.offset().top - 100 }, 320);
    }
  });
})(jQuery);

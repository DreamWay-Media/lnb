jQuery(function ($) {
  /** Single row: prev — dots — next (20px gaps via CSS on .blog-carousel-dots-row) */
  function mergeBlogCarouselControls($c) {
    if (!$c || !$c.length) {
      return;
    }
    if ($c.children('.blog-carousel-dots-row').length) {
      return;
    }
    var $nav = $c.children('.owl-nav');
    var $dots = $c.children('.owl-dots');
    if (!$nav.length || !$dots.length) {
      return;
    }
    var $prev = $nav.find('.owl-prev').first();
    var $next = $nav.find('.owl-next').first();
    if (!$prev.length || !$next.length) {
      return;
    }
    var $row = $('<div class="blog-carousel-dots-row" />');
    $row.append($prev, $dots, $next);
    $c.find('.owl-stage-outer').first().after($row);
    $nav.remove();
  }

  function initBlogCarousel() {
    var $c = $('#blog-post-carousel');
    if (!$c.length || typeof $.fn.owlCarousel !== 'function') {
      return;
    }
    if ($c.data('owl.carousel')) {
      return;
    }
    var n = $c.children('.blog-carousel-card').length;
    $c.owlCarousel({
      loop: n > 3,
      margin: 24,
      nav: true,
      dots: true,
      slideBy: 'page',
      navText: [
        '<span class="blog-carousel-nav-btn" aria-hidden="true">&#8249;</span>',
        '<span class="blog-carousel-nav-btn" aria-hidden="true">&#8250;</span>'
      ],
      responsive: {
        0: { items: 1 },
        576: { items: 2 },
        992: { items: 3 }
      },
      onInitialized: function () {
        mergeBlogCarouselControls($c);
      },
      onRefreshed: function () {
        if (
          !$c.children('.blog-carousel-dots-row').length &&
          $c.children('.owl-nav').length &&
          $c.children('.owl-dots').length
        ) {
          mergeBlogCarouselControls($c);
        }
      }
    });
  }

  initBlogCarousel();
  $(window).on('load', initBlogCarousel);

  /* Carousel */
  if ($('#owl-carousel').length) {
    $('#owl-carousel').owlCarousel({
      loop: false,
      margin: 0,
      nav: false,
      dots: false,
      responsive: {
        0: { items: 1 },
        600: { items: 1 },
        1000: { items: 1 }
      }
    });
  }
  $('.lnb-carousel').carousel({
    interval: 2000
  });

  $(".product .summary .mvvwb_date_start label").nextUntil("") // get elements from hr upto the previous element of #disqus_thread
    .wrapAll("<div class=wrapper></div>"); // wrap all elements using div

  /* header fix on scroll — rAF to avoid excessive work on scroll */
  var scrollTicking = false;
  $(window).on("scroll", function () {
    if (scrollTicking) {
      return;
    }
    scrollTicking = true;
    window.requestAnimationFrame(function () {
      var scroll = $(window).scrollTop();
      if (scroll >= 30) {
        $("header.header").addClass("fixed");
      } else {
        $("header.header").removeClass("fixed");
      }
      scrollTicking = false;
    });
  });
});

  document.addEventListener( 'wpcf7mailsent', function( event ) {
    document.querySelectorAll("form.wpcf7-form > :not(.wpcf7-response-output)").forEach(el => {
      el.style.display = 'none';
    });
  }, false );

$(document).ready(function(){
  /* Carousel */
  if($('#owl-carousel').length){
    $('#owl-carousel').owlCarousel({
      loop: false,
      margin: 0,
      nav: false,
      dots:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
        }
    });
  }
  $('.lnb-carousel').carousel({
  interval: 2000
});

 $(".product .summary .mvvwb_date_start label").nextUntil("") // get elements from hr upto the previous element of #disqus_thread
        .wrapAll("<div class=wrapper></div>"); // wrap all elements using div
	
	
	/* header fix on scrol*/
  $(window).scroll(function() {
      var scroll = $(window).scrollTop();

      if (scroll >= 30) {
          $("header.header").addClass("fixed");
      } else {
          $("header.header").removeClass("fixed");
      }
  });

})

  document.addEventListener( 'wpcf7mailsent', function( event ) {
    document.querySelectorAll("form.wpcf7-form > :not(.wpcf7-response-output)").forEach(el => {
      el.style.display = 'none';
    });
  }, false );

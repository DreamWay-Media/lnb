	<footer>
	  <div class="container">
		<div class="row">
        <div class="col-md-12">
        <div class="footer_google_image">
        <a href="https://www.google.com/search?q=love+n+bride&rlz=1C5GCEM_enUS1059US1059&oq=love+n+bride&aqs=chrome.0.0i355i512j46i175i199i512j69i64j0i10i512j0i22i30l2j69i60l2.9079j0j4&sourceid=chrome&ie=UTF-8#lkt=LocalPoiReviews&lrd=0x80dce9c962f6db89:0x3934f864d66f8c8c,3,,,,&rlimm=4122192670928899212" target="_blank" rel="noopener noreferrer" style="background: url('https://lovenbride.com/wp-content/uploads/2023/10/s.png'); background-color:#9b195e;"></a>
        </div>
        </div>
		  <div class="col-lg-4 col-12">
			<div class="footer-logo footer-content">
			  <?php if(is_active_sidebar('footer1')):?>
				<?php dynamic_sidebar( 'footer1' ); ?>
			  <?php endif;?>
			</div>
		  </div>
		  <div class="col-lg-3 col-12">
			<div class="footer-menu footer-content">
			  <?php if(is_active_sidebar('footer2')):?>
				<?php dynamic_sidebar( 'footer2' ); ?>
			  <?php endif;?>
			</div>
		  </div>
		  <div class="col-lg-3 col-12">
			<div class="footer-contact footer-content">
			  <?php if(is_active_sidebar('footer3')):?>
				<?php dynamic_sidebar( 'footer3' ); ?>
			  <?php endif;?>
			</div>
		  </div>
		  <div class="col-lg-2 col-12">
			<div class="footer-social footer-content">
			  <?php if(is_active_sidebar('footer4')):?>
				<?php dynamic_sidebar( 'footer4' ); ?>
			  <?php endif;?>
			</div>
		  </div>
		</div>
		<div class="row">
		  <div class="col-12 copyright">
			  <div class="footer_bottom_section">
				  <p>&copy;<?php echo esc_html( wp_date( 'Y' ) ); ?> Love N Bride. All Rights Reserved</p>
			  </div>
		  </div>
		</div>
	  </div>
	  <?php wp_footer(); ?>
	</footer>
</body>
</html>
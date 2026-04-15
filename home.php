<?php
/*
Template Name: Home page
*/
if ( is_home() && ! is_front_page() ) {
	get_template_part( 'template-parts/blog', 'archive' );
	return;
}

	$acf_home_id = dwm_lnb_home_acf_page_id();

	/*-----Services Section-----*/
	$services_title         = dwm_lnb_get_field( 'services_title', $acf_home_id );
	$services_description   = dwm_lnb_get_field( 'services_description', $acf_home_id );
	$left_service_image     = dwm_lnb_get_field( 'left_service_image', $acf_home_id );
	$left_service_title     = dwm_lnb_get_field( 'left_service_title', $acf_home_id );
	$left_service_desc      = dwm_lnb_get_field( 'left_service_desc', $acf_home_id );
	$middle_service_image   = dwm_lnb_get_field( 'middle_service_image', $acf_home_id );
	$middle_service_title   = dwm_lnb_get_field( 'middle_service_title', $acf_home_id );
	$middle_service_desc    = dwm_lnb_get_field( 'middle_service_desc', $acf_home_id );
	$right_service_image    = dwm_lnb_get_field( 'right_service_image', $acf_home_id );
	$right_service_title    = dwm_lnb_get_field( 'right_service_title', $acf_home_id );
	$right_service_desc     = dwm_lnb_get_field( 'right_service_desc', $acf_home_id );

	/*-----About Section-----*/
	$about_title_line_1 = dwm_lnb_get_field( 'about_title_line_1', $acf_home_id );
	$about_title_line_2 = dwm_lnb_get_field( 'about_title_line_2', $acf_home_id );
	$about_desc         = dwm_lnb_get_field( 'about_desc', $acf_home_id );
	$about_background   = dwm_lnb_get_field( 'about_background', $acf_home_id );
	$about_link_title   = dwm_lnb_get_field( 'about_link_title', $acf_home_id );
	$about_link_url     = dwm_lnb_get_field( 'about_link_url', $acf_home_id );

	/*-----Contact Section-----*/
	$contact_title          = dwm_lnb_get_field( 'contact_title', $acf_home_id );
	$contact_description    = dwm_lnb_get_field( 'contact_description', $acf_home_id );
	$contact_form_shortcode = dwm_lnb_get_field( 'contact_form_shortcode', $acf_home_id );
	$contact_background     = dwm_lnb_get_field( 'contact_background', $acf_home_id );
	$contact_map_shortcode    = dwm_lnb_get_field( 'contact_map_shortcode', $acf_home_id );

	/*-----Products Section-----*/
	$products_title       = dwm_lnb_get_field( 'products_title', $acf_home_id );
	$products_desc        = dwm_lnb_get_field( 'products_desc', $acf_home_id );
	$products_shortcode   = dwm_lnb_get_field( 'products_shortcode', $acf_home_id );
?>
<?php get_header('home'); ?>
<main id="homepage" class="homepage">
	<?php
	$slider = new WP_Query(
		array(
			'post_type'      => 'slider',
			'posts_per_page' => 3,
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		)
	);
	$slider_title      = '';
	$slider_text       = '';
	$slider_link_title = '';
	$slider_link_url   = '';
	if ( $slider->have_posts() ) {
		$slider->the_post();
		$slider_title      = get_the_title();
		$slider_text       = apply_filters( 'the_content', get_the_content() );
		$slider_link_title = dwm_lnb_get_field( 'slide_link_title' );
		$slider_link_url   = dwm_lnb_get_field( 'slide_link_url' );
		$slider->rewind_posts();
	}
	$flower_img_base = get_stylesheet_directory_uri() . '/imgs';
	?>
	<section class="hero-section">
		<div class="row">
		  <div class="col-12">
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
			  <div class="carousel-inner">
				<?php
				$slide_i = 0;
				while ( $slider->have_posts() ) :
					$slider->the_post();
					++$slide_i;
					$bg = wp_get_attachment_url( get_post_thumbnail_id() );
					?>
					<div class="carousel-item <?php echo ( 1 === $slide_i ) ? 'active' : ''; ?>">
						<div class="img-container" style="background-image:url(<?php echo $bg ? esc_url( $bg ) : ''; ?>)"></div>
					</div>
					<?php
				endwhile;
				if ( $slide_i > 0 ) {
					$slider->rewind_posts();
				}
				?>
				  <div class="container full-height">
								<div class="slide_content">
									<div class="title">
										 <?php echo wp_kses_post( $slider_title ); ?>
									</div>
									<div class="desc">
										<?php echo wp_kses_post( $slider_text ); ?>
									</div>
									<div class="btn default">
										<a href="<?php echo esc_url( $slider_link_url ); ?>"><?php echo esc_html( $slider_link_title ); ?></a>
									</div>
								</div>
							</div>	
			  </div>
				<?php
				if ( $slider->have_posts() ) :
					$ind = 0;
					?>
				<div class="carousel-indicators">
					  <?php
						while ( $slider->have_posts() ) :
							$slider->the_post();
							?>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo (int) $ind; ?>" class="<?php echo 0 === $ind ? 'active' : ''; ?>" aria-current="<?php echo 0 === $ind ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'dwm-lnb' ), $ind + 1 ) ); ?>"></button>

				<?php
						++$ind;
					endwhile;
					?>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			</div>
		  </div>
		</div>
    </section>
	<section class="service-section">
		<div class="flower_left"><img src="<?php echo esc_url( $flower_img_base . '/flower_left.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
		<div class="flower_right"><img src="<?php echo esc_url( $flower_img_base . '/flower_right.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<?php if($services_title): ?>
						<h3 class="section_title"><?=$services_title;?></h3>
					<?php endif; ?><br/>
					<?php if($services_description): ?>
						<div class="services_description"><p><?=$services_description;?></p></div>
					<?php endif; ?>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_left">
					<div class="service_holder">
						<img src="<?=$left_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$left_service_title;?></h3>
							<div class="service_desc"><p><?=$left_service_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_middle">
					<div class="service_holder">
						<img src="<?=$middle_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$middle_service_title;?></h3>
							<div class="service_desc"><p><?=$middle_service_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_right">
					<div class="service_holder">
						<img src="<?=$right_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$right_service_title;?></h3>
							<div class="service_desc"><p><?=$right_service_desc;?></p></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="about-section" style="background-image:url('<?=$about_background;?>');">
		<div class="gradient_background">		
			<div class="container full-height">
				<div class="about_container">
					<h3 class="about_title_line_1"><?=$about_title_line_1;?></h3><br/>
					<h3 class="about_title_line_2"><?=$about_title_line_2;?></h3>
					<div class="about_desc"><p><?=$about_desc;?></p></div>
					<div class="btn default">
						<a href="<?=$about_link_url;?>"><?=$about_link_title;?></a>
					</div>
				</div>
			</div>
		</div>
		<img src="<?=$about_background;?>" class="about-img small-view">
	</section>
	<!--<section class="promotion-section">
		<p>&nbsp;</p>
	</section>-->
	<section class="products-section">		
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<?php if($products_title): ?>
						<h3 class="section_title"><?=$products_title;?></h3>
					<?php endif; ?><br/>
					<?php if($products_desc): ?>
						<div class="services_description"><p><?=$products_desc;?></p></div>
					<?php endif; ?>
					<?php if($products_shortcode): ?>
					<div class="products_list">
						<?php echo do_shortcode($products_shortcode);?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/home', 'blog-carousel' ); ?>

	<section class="instagram-section">
	    <div class="container">
	        <div class="row">
				<div class="about_container">
					<h3 class="about_title_line_1">Instagram</h3><br>
					<h3 class="about_title_line_2">Latest Posts</h3>
				</div>
	            <?php dynamic_sidebar( 'instagram_feed' ); ?>
	        </div>
	    </div>
	</section>
	<section class="contact-section" style="background-image:url('<?=$contact_background;?>');">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-6 map-holder">
					<div class="map"><?php echo ($contact_map_shortcode); ?></div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 contact-holder">				
					<div class="contact_content">
						<h3 class="contact_title"><?=$contact_title;?></h3>
						<div class="contact_desc"><p><?=$contact_description;?></p></div>
						<div class="contact_form"><?php echo do_shortcode($contact_form_shortcode); ?></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="reviews-section">		
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
				    <h2><br/><br/><br/></h2>
	                <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
	                <h2><br/><br/><br/></h2>
	            </div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>

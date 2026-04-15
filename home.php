<?php
/*
Template Name: Home page
*/
?>
<?php
	/*-----Services Section-----*/
	$services_title = get_field( "services_title", 68 );
	$services_description = get_field( "services_description", 68 );
	$left_service_image = get_field( "left_service_image", 68 );
	$left_service_title = get_field( "left_service_title", 68 );
	$left_service_desc = get_field( "left_service_desc", 68 );
	$middle_service_image = get_field( "middle_service_image", 68 );
	$middle_service_title = get_field( "middle_service_title", 68 );
	$middle_service_desc = get_field( "middle_service_desc", 68 );
	$right_service_image = get_field( "right_service_image", 68 );
	$right_service_title = get_field( "right_service_title", 68 );
	$right_service_desc = get_field( "right_service_desc", 68 );
	
	/*-----About Section-----*/
	$about_title_line_1 = get_field( "about_title_line_1", 68 );
	$about_title_line_2 = get_field( "about_title_line_2", 68 );
	$about_desc = get_field( "about_desc", 68 );
	$about_background = get_field( "about_background", 68 );
	$about_link_title = get_field( "about_link_title", 68 );
	$about_link_url = get_field( "about_link_url", 68 );
	
	/*-----Contact Section-----*/
	$contact_title = get_field( "contact_title", 68 );
	$contact_description = get_field( "contact_description", 68 );
	$contact_form_shortcode = get_field( "contact_form_shortcode", 68 );
	$contact_background = get_field( "contact_background", 68 );
	$contact_map_shortcode = get_field( "contact_map_shortcode", 68 );
	
	/*-----Products Section-----*/
	$products_title = get_field( "products_title", 68 );
	$products_desc = get_field( "products_desc", 68 );
	$products_shortcode = get_field( "products_shortcode", 68 );
	
	
?>
<?php get_header('home'); ?>
<main id="homepage" class="homepage">
	<section class="hero-section">
		<div class="row">
		  <div class="col-12">
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
			  <div class="carousel-inner">
				  <?php $slider_content = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => 1 ) );
				  $slider_content->the_post();
					
				  $slider_title = get_the_title();
				  $slider_text = get_the_content();
				  $slider_link_title = get_field( "slide_link_title", $slider_content->ID );
				  $slider_link_url =  get_field( "slide_link_url", $slider_content->ID );
				  ?>
				  
				<?php $slider = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => 3 ) ); ?>
				<?php
				$counter = 0;
				while ( $slider->have_posts() ) : $slider->the_post();
					$counter++;
				?>
					<div class="carousel-item <?=($counter == 1) ? 'active' : ''?>">
						<div class="img-container" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($slider->ID)); ?>)">
							
						</div>
					</div>
					<?php endwhile; wp_reset_query(); ?>
				  <div class="container full-height">
								<div class="slide_content">
									<div class="title">
										 <?=$slider_title; ?>
									</div>
									<div class="desc">
										<?=$slider_text;?>
									</div>
									<div class="btn default">
										<a href="<?=$slider_link_url;?>"><?=$slider_link_title;?></a>
									</div>
								</div>
							</div>	
			  </div>
				<?php if( $slider->have_posts()): $counter = 0; ?>
				<div class="carousel-indicators">
					  <?php while ($slider->have_posts()): $slider->the_post(); ?>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $counter; ?>" class="<?php if($counter == 0) echo 'active'; ?>" aria-current="true" aria-label="Slide <?=$counter?>"></button>

				<?php $counter++; endwhile; ?>
				</div>
			<?php endif; ?> 
			</div>
		  </div>
		</div>
    </section>
	<section class="service-section">
		<div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		<div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
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

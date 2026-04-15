<?php
/*
Template Name: About Page
*/
?>
<?php
		
	/*-----About Page Fields-----*/
	$about_page_title = get_field( "about_page_title", 28 );
	$about_page_subtitle = get_field( "about_page_subtitle", 28 );
	$quote_section_title = get_field( "quote_section_title", 28 );
	$quote_text = get_field( "quote_text", 28 );
	$quote_signature = get_field( "quote_signature", 28 );
	
	
?>
<?php get_header('home'); ?>
<main id="aboutpage" class="aboutpage">
	<section class="content large-view">
		<div class="container">
			<div class="row">
				<div class="col-12 content-holder" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($page->ID)); ?>)">
					<div class="about-content">
						<div class="page-title">
							<h2><?=$about_page_title;?></h2>
							<h1><?=$about_page_subtitle;?></h1>
						</div>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="quote-section">
		    <div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		    <div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
			<div class="container">
				<div class="quote_section_title"><?=$quote_section_title?></div>
				<div class="quote_text"><?=$quote_text?></div>
				<div class="quote_signature"><?=$quote_signature?></div>
			</div>
		</div>
	</section>
	<section class="content small-view">
		<div class="container">
			<div class="row">
				<div class="col-12 content-holder" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($page->ID)); ?>)">
					<div class="about-content">
						<div class="page-title">
							<h2><?=$about_page_title;?></h2>
							<h1><?=$about_page_subtitle;?></h1>
						</div>
					</div>
				</div>
				<div class="col-12 content">				
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<div class="quote-section">
		    <div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		    <div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
			<div class="container">
				<div class="quote_section_title"><?=$quote_section_title?></div>
				<div class="quote_text"><?=$quote_text?></div>
				<div class="quote_signature"><?=$quote_signature?></div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>

<?php
/*
Template Name: Alteration Page
*/
?>
<?php
		
	/*-----Alteration Hero Fields-----*/
	$alteration_page_title = get_field( "alteration_page_title", 30 );
	$alteration_page_title_2 = get_field( "alteration_page_title_2", 30 );
	$alteration_text = get_field( "alteration_text", 30 );
	$alteration_button_link_title = get_field( "alteration_button_link_title", 30 );
	$alteration_button_link_url = get_field( "alteration_button_link_url", 30 );
	$alternation_content_title = get_field( "alternation_content_title", 30 );
	$quote_section_title = get_field( "quote_section_title", 30 );
	$quote_text = get_field( "quote_text", 30 );
	$quote_signature = get_field( "quote_signature", 30 );
	
	/*-----Alteration Icon Fields-----*/
	$first_icon = get_field( "1st_icon", 30 );
	$first_icon_title = get_field( "1st_icon_title", 30 );
	$first_icon_text = get_field( "1st_icon_text", 30 );
	$second_icon = get_field( "2nd_icon", 30 );
	$second_icon_title = get_field( "2nd_icon_title", 30 );
	$second_icon_text = get_field( "2nd_icon_text", 30 );
	$third_icon = get_field( "3rd_icon", 30 );
	$third_icon_title = get_field( "3rd_icon_title", 30 );
	$third_icon_text = get_field( "3rd_icon_text", 30 );
	
?>
<?php get_header('home'); ?>
<main id="alteration" class="alterationpage">
	<section class="content large-view" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($page->ID)); ?>)">
		<div class="container">
			<div class="row">
				<div class="col-12 content-holder">
					<div class="about-content">
						<div class="page-title">
							<h2 class="section_title"><?=$alteration_page_title;?></h2>
							<h1><?=$alteration_page_title_2;?></h1>
						</div>
						<?=$alteration_text; ?>						
						<?php if(get_field('alteration_button_link_url')): ?>
							<div class="btn default">
								<a href="<?=$alteration_button_link_url;?>"><?=$alteration_button_link_title;?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content small-view" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($page->ID)); ?>)">
		<div class="container">			
			<div class="row">
				<div class="col-12 content-holder">
					<div class="about-content">
						<div class="page-title">
							<h2 class="section_title"><?=$alteration_page_title;?></h2>
							<h1><?=$alteration_page_title_2;?></h1>
						</div>
						<?=$alteration_text; ?>						
						<?php if(get_field('alteration_button_link_url')): ?>
							<div class="btn default">
								<a href="<?=$alteration_button_link_url;?>"><?=$alteration_button_link_title;?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="quote-section">
			<div class="container">
				<div class="quote_section_title"><?=$quote_section_title?></div>
				<div class="quote_text"><?=$quote_text?></div>
				<div class="quote_signature"><?=$quote_signature?></div>
			</div>
		</div>
	</section>
	<!--<section class="alteration_steps">
		<div class="container">			
			<div class="row">
				<div class="col-lg-4 col-sm-12">
					<div class="alternation_step_title"><?=$first_icon_title?></div>
					<div class="alternation_step_text"><?=$first_icon_text?></div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="alternation_step_title"><?=$second_icon_title?></div>
					<div class="alternation_step_text"><?=$second_icon_text?></div>
				
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="alternation_step_title"><?=$third_icon_title?></div>
					<div class="alternation_step_text"><?=$third_icon_text?></div>
				</div>
			</div>
		</div>
	</section>-->
	<section class="alteration_desc">
		    <div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		    <div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
		<div class="container">
			<h2 class="alternation_content_title"><?=$alternation_content_title?></h2>
			<div class="alternation_text">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	
</main>

<?php get_footer(); ?>

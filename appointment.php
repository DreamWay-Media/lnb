<?php
/*
Template Name: Appointment Page
*/
?>
<?php
		
	/*-----Appointment Hero Fields-----*/
	$appointment_title_line_1 = get_field( "appointment_title_line_1", 236 );
	$appointment_title_line_2 = get_field( "appointment_title_line_2", 236 );
	$appointment_desc = get_field( "appointment_desc", 236 );
	$appointment_link_title = get_field( "appointment_link_title", 236 );
	$appointment_link_url = get_field( "appointment_link_url", 236 );
	
	/*-----Alteration Icon Fields-----*/
	$appointment_desc_title_line_1 = get_field( "appointment_desc_title_line_1", 236 );
	$appointment_desc_title_line_2 = get_field( "appointment_desc_title_line_2", 236 );
	$service_1_image = get_field( "service_1_image", 236 );
	$service_1_title = get_field( "service_1_title", 236 );
	$service_1_desc = get_field( "service_1_desc", 236 );
	$service_2_image = get_field( "service_2_image", 236 );
	$service_2_title = get_field( "service_2_title", 236 );
	$service_2_desc = get_field( "service_2_desc", 236 );
	$service_3_image = get_field( "service_3_image", 236 );
	$service_3_title = get_field( "service_3_title", 236 );
	$service_3_desc = get_field( "service_3_desc", 236 );
	$service_4_image = get_field( "service_4_image", 236 );
	$service_4_title = get_field( "service_4_title", 236 );
	$service_4_desc = get_field( "service_4_desc", 236 );
	$service_5_image = get_field( "service_5_image", 236 );
	$service_5_title = get_field( "service_5_title", 236 );
	$service_5_desc = get_field( "service_5_desc", 236 );
	$service_6_image = get_field( "service_6_image", 236 );
	$service_6_title = get_field( "service_6_title", 236 );
	$service_6_desc = get_field( "service_6_desc", 236 );
	
?>
<?php get_header('home'); ?>
<main id="appointment" class="appointmentpage">
	<section class="content large-view" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($page->ID)); ?>)">
		<div class="container">
			<div class="row">
				<div class="col-12 content-holder">
					<div class="about-content">
						<div class="page-title">
							<h2><?=$appointment_title_line_1;?></h2><br />
							<h1><?=$appointment_title_line_2;?></h1>
						</div>
						<p><?=$appointment_desc; ?></p>
							<div class="btn default">
								<a href="<?=$appointment_link_url;?>"><?=$appointment_link_title;?></a>
							</div>
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
							<h2><?=$appointment_title_line_1;?></h2><br />
							<h1><?=$appointment_title_line_2;?></h1>
						</div>
						<p><?=$appointment_desc; ?></p>
							<div class="btn default">
								<a href="<?=$appointment_link_url;?>"><?=$appointment_link_title;?></a>
							</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="appointment_desc">
		    <div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		    <div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
		<div class="container">
			<div class="page-title">
				<h2><?=$appointment_desc_title_line_1;?></h2><br />
				<h1><?=$appointment_desc_title_line_2;?></h1>
			</div>
			<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-4 service_left">
					<div class="service_holder">
						<img src="<?=$service_1_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_1_title;?></h3>
							<div class="service_desc"><p><?=$service_1_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_middle">
					<div class="service_holder">
						<img src="<?=$service_2_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_2_title;?></h3>
							<div class="service_desc"><p><?=$service_2_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_right">
					<div class="service_holder">
						<img src="<?=$service_3_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_3_title;?></h3>
							<div class="service_desc"><p><?=$service_3_desc;?></p></div>
						</div>
					</div>
				</div>
			<div class="col-sm-12 col-md-12 col-lg-4 service_left">
					<div class="service_holder">
						<img src="<?=$service_4_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_4_title;?></h3>
							<div class="service_desc"><p><?=$service_4_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_middle">
					<div class="service_holder">
						<img src="<?=$service_5_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_5_title;?></h3>
							<div class="service_desc"><p><?=$service_5_desc;?></p></div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_right">
					<div class="service_holder">
						<img src="<?=$service_6_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$service_6_title;?></h3>
							<div class="service_desc"><p><?=$service_6_desc;?></p></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
</main>

<?php get_footer(); ?>

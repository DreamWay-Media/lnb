<?php
/*
Template Name: Collection page
*/
?>
<?php
	/*-----Services Section-----*/
	//$services_title = get_field( "services_title", 68 );
	//$services_description = get_field( "services_description", 68 );
	
	$left_service_image = get_field( "left_service_image");
	$left_service_title = get_field( "left_service_title" );
	$left_service_desc = get_field( "left_service_desc");
	$left_service_link = get_field( "left_service_link");
	
	$middle_service_image = get_field( "middle_service_image");
	$middle_service_title = get_field( "middle_service_title");
	$middle_service_desc = get_field( "middle_service_desc");
	$middle_service_link = get_field( "middle_service_link");
	
	$right_service_image = get_field( "right_service_image");
	$right_service_title = get_field( "right_service_title");
	$right_service_desc = get_field( "right_service_desc");
	$right_service_link = get_field( "right_service_link");
	
?>
<?php get_header('home'); ?>
<style>
body main#homepage section.service-section {
	    margin-top: 186px;

}
</style>
<main id="homepage" class="homepage">

	<section class="service-section">
		<div class="flower_left"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_left.png"></div>
		<div class="flower_right"><img src="https://dev.lovenbride.com/wp-content/themes/dreamway/imgs/flower_right.png"></div>
		<div class="container">
			<div class="row">
			
				<div class="col-sm-12 col-md-12 col-lg-4 service_left">
					<a href="<?=$left_service_link;?>">
					<div class="service_holder">
						<img src="<?=$left_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$left_service_title;?></h3>
							<div class="service_desc"><p><?=$left_service_desc;?></p></div>
						</div>
					</div>
					</a>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_middle">
					<a href="<?=$middle_service_link;?>" target="_blank">
					<div class="service_holder">
						<img src="<?=$middle_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$middle_service_title;?></h3>
							<div class="service_desc"><p><?=$middle_service_desc;?></p></div>
						</div>
					</div>
					</a>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 service_right">
					<a href="<?=$right_service_link;?>" target="_blank"> 
					<div class="service_holder">
						<img src="<?=$right_service_image;?>">
						<div class="service_content">
							<h3 class="service_title"><?=$right_service_title;?></h3>
							<div class="service_desc"><p><?=$right_service_desc;?></p></div>
						</div>
					</div>
					</a>
				</div>
			</div>
		</div>
	</section>
	
</main>

<?php get_footer(); ?>

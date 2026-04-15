<?php
/*
Template Name: Archive Page
*/
?>
<?php get_header(); ?>
<main id="recipes">
	<div class="page-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<div class="row">
        <div class="col-12 text-center"><h1 class="woocommerce-products-header__title page-title">
            Recipes
        </h1></div>
        <div class="col-12 text-center">
		<div class="breadcrumb-container">
          <?php
			if ( function_exists('yoast_breadcrumb') ) {
			  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
			}
			?>
        </div>
			
		</div>
      <?php endif; ?>
	</div>
  </div>	
	<section>
		<div class="container">
			<div class="row blog_posts">
				<div class="col-lg-12">
				<?php $blog_posts = get_posts(array('post_type' => 'post', 'numberposts' => -1)); ?>
					<?php foreach ($blog_posts as $blog_post):
						 $parent_page_id = get_the_ID(); ?>
						 <div class="col-12 col-md-6 col-lg-4 recipe-item">
							 <div class="recipe-wrapper">
								<div class="img-container">
									 <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($blog_post->ID)); ?>">
								</div>
								<div class="recipe-info">
									<h2 class="title"><?php echo get_the_title($blog_post->ID); ?></h2>
									<p class="desc"><?php echo get_the_excerpt($blog_post->ID); ?></p> 
								</div>
								 <div class="readmore">
									<a class="btn" href="<?php echo get_the_permalink($blog_post->ID); ?>">view recipe</a>								 
								 </div>								 
							 </div>
						</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
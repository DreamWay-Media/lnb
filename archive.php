<?php
/**
 * Recipes archive (legacy layout). Post category/tag archives use template-parts/blog-archive.php
 * via category.php / tag.php / template_include — not this markup.
 */
// Post category/tag archives: use blog layout (this file is also the generic archive fallback).
if ( function_exists( 'dwm_lnb_is_blog_category_or_tag_archive' ) && dwm_lnb_is_blog_category_or_tag_archive() ) {
	$tpl = locate_template( 'template-parts/blog-archive.php', false, false );
	if ( $tpl ) {
		load_template( $tpl, false );
		return;
	}
}

$paged = (int) get_query_var( 'paged' );
if ( $paged < 1 ) {
	$paged = (int) get_query_var( 'page' );
}
if ( $paged < 1 ) {
	$paged = 1;
}
$ppp   = max( 1, (int) get_option( 'posts_per_page', 12 ) );

$recipes_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => $ppp,
		'paged'          => $paged,
		'post_status'    => 'publish',
	)
);
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
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
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
				<?php
				if ( $recipes_query->have_posts() ) :
					while ( $recipes_query->have_posts() ) :
						$recipes_query->the_post();
						$thumb = get_post_thumbnail_id();
						?>
						 <div class="col-12 col-md-6 col-lg-4 recipe-item">
							 <div class="recipe-wrapper">
								<div class="img-container">
									 <?php if ( $thumb ) : ?>
									 <img src="<?php echo esc_url( wp_get_attachment_url( $thumb ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
									 <?php endif; ?>
								</div>
								<div class="recipe-info">
									<h2 class="title"><?php the_title(); ?></h2>
									<p class="desc"><?php echo esc_html( get_the_excerpt() ); ?></p> 
								</div>
								 <div class="readmore">
									<a class="btn" href="<?php the_permalink(); ?>">view recipe</a>								 
								 </div>								 
							 </div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '<p class="col-12">' . esc_html__( 'No recipes found.', 'dwm-lnb' ) . '</p>';
				endif;
				?>
				</div>
				<?php
				if ( $recipes_query->max_num_pages > 1 ) {
					echo '<nav class="col-12 navigation recipe-archive__pagination" aria-label="' . esc_attr__( 'Recipes pagination', 'dwm-lnb' ) . '">';
					echo wp_kses_post(
						paginate_links(
							array(
								'total'     => $recipes_query->max_num_pages,
								'current'   => $paged,
								'prev_text' => '&laquo; ' . __( 'Previous', 'dwm-lnb' ),
								'next_text' => __( 'Next', 'dwm-lnb' ) . ' &raquo;',
								'type'      => 'list',
							)
						)
					);
					echo '</nav>';
				}
				?>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>

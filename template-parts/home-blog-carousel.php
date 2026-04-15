<?php
/**
 * Homepage section: blog posts carousel (Owl).
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

$home_fields_page_id = dwm_lnb_home_acf_page_id();

$blog_carousel_title_1 = dwm_lnb_get_field( 'blog_carousel_title_line_1', $home_fields_page_id );
$blog_carousel_title_2 = dwm_lnb_get_field( 'blog_carousel_title_line_2', $home_fields_page_id );
if ( ! $blog_carousel_title_1 ) {
	$blog_carousel_title_1 = 'From the';
}
if ( ! $blog_carousel_title_2 ) {
	$blog_carousel_title_2 = 'Blog';
}

$blog_carousel_archive_url = home_url( '/blog/' );

/*
 * Post count: same as Settings > Reading > "Blog pages show at most" (get_option posts_per_page).
 * Optional ACF number field on the home fields page: blog_carousel_posts_count (overrides when set).
 */
$blog_carousel_posts_per_page = (int) get_option( 'posts_per_page', 12 );
$acf_carousel_count           = dwm_lnb_get_field( 'blog_carousel_posts_count', $home_fields_page_id );
if ( null !== $acf_carousel_count && false !== $acf_carousel_count && '' !== $acf_carousel_count ) {
	$blog_carousel_posts_per_page = (int) $acf_carousel_count;
}
$blog_carousel_posts_per_page = max( 1, min( 100, $blog_carousel_posts_per_page ) );
$blog_carousel_posts_per_page = (int) apply_filters( 'dwm_lnb_blog_carousel_posts_per_page', $blog_carousel_posts_per_page, $home_fields_page_id );

$blog_carousel_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $blog_carousel_posts_per_page,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $blog_carousel_query->have_posts() ) {
	return;
}
?>

<section class="blog-carousel-section" aria-label="<?php echo esc_attr( $blog_carousel_title_1 . ' ' . $blog_carousel_title_2 ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<h3 class="about_title_line_1"><?php echo esc_html( $blog_carousel_title_1 ); ?></h3><br/>
				<h3 class="about_title_line_2"><?php echo esc_html( $blog_carousel_title_2 ); ?></h3>
			</div>
		</div>
		<div class="blog-carousel-section__slider-wrap">
			<div id="blog-post-carousel" class="owl-carousel owl-theme">
				<?php
				while ( $blog_carousel_query->have_posts() ) :
					$blog_carousel_query->the_post();
					$thumb_id = get_post_thumbnail_id();
					?>
				<article <?php post_class( 'blog-carousel-card' ); ?>>
					<a href="<?php the_permalink(); ?>" class="blog-carousel-card__link">
						<div class="blog-carousel-card__image">
							<?php
							if ( $thumb_id ) {
								echo wp_get_attachment_image(
									$thumb_id,
									'medium_large',
									false,
									array( 'class' => 'blog-carousel-card__img' )
								);
							} else {
								echo '<div class="blog-carousel-card__placeholder" aria-hidden="true"></div>';
							}
							?>
						</div>
						<div class="blog-carousel-card__body">
							<h4 class="blog-carousel-card__title"><?php the_title(); ?></h4>
							<p class="blog-carousel-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16, '…' ) ); ?></p>
							<span class="blog-carousel-card__cta">Read more</span>
						</div>
					</a>
				</article>
				<?php endwhile; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center blog-carousel-section__footer">
				<div class="btn default">
					<a href="<?php echo esc_url( $blog_carousel_archive_url ); ?>">View all posts</a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

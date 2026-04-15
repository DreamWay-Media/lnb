<?php
/**
 * Single blog post — content + widget sidebar.
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

get_header();

$sidebar_active   = is_active_sidebar( 'single_post_sidebar' );
$show_placeholder = ! $sidebar_active && current_user_can( 'edit_theme_options' );
$has_aside        = $sidebar_active || $show_placeholder;
$content_class    = $has_aside ? 'col-12 col-lg-8 single-post__content-col' : 'col-12 col-xl-10 offset-xl-1 single-post__content-col';
?>
<main id="single-post" class="single-post">
	<div class="breadcrumb_holder">
		<div class="container">
			<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) : ?>
				<?php rank_math_the_breadcrumbs(); ?>
			<?php elseif ( function_exists( 'yoast_breadcrumb' ) ) : ?>
				<?php yoast_breadcrumb( '', '' ); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
	<div class="container single-post__container">
		<div class="row g-4 g-xl-5 single-post__row">
			<div class="<?php echo esc_attr( $content_class ); ?>">
				<article <?php post_class( 'single-post__article' ); ?> id="post-<?php the_ID(); ?>">
					<?php get_template_part( 'template-parts/content', 'single' ); ?>
				</article>
			</div>
			<?php if ( $has_aside ) : ?>
			<aside class="col-12 col-lg-4 single-post__sidebar-col" aria-label="<?php esc_attr_e( 'Article sidebar', 'dwm-lnb' ); ?>">
				<div class="single-post__sidebar">
					<?php if ( $sidebar_active ) : ?>
						<?php dynamic_sidebar( 'single_post_sidebar' ); ?>
					<?php elseif ( $show_placeholder ) : ?>
						<section class="single-sidebar__widget single-sidebar__widget--placeholder">
							<h3 class="single-sidebar__widget-title"><?php esc_html_e( 'Sidebar', 'dwm-lnb' ); ?></h3>
							<p class="single-sidebar__placeholder-text">
								<?php esc_html_e( 'Add widgets under Appearance → Widgets → “Blog post sidebar” (Recent Posts, Categories, Search, newsletter HTML, etc.).', 'dwm-lnb' ); ?>
							</p>
						</section>
					<?php endif; ?>
				</div>
			</aside>
			<?php endif; ?>
		</div>
	</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();

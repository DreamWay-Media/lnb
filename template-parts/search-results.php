<?php
/**
 * Search results listing (same layout as blog archive grid, no AJAX filters).
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

get_header();

global $wp_query;

$q          = get_search_query();
$page_title = $q
	? sprintf(
		/* translators: %s: search query */
		__( 'Search results for "%s"', 'dwm-lnb' ),
		$q
	)
	: __( 'Search', 'dwm-lnb' );

$found = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;

$paged_num = max( 1, (int) get_query_var( 'paged' ) );
if ( $paged_num < 1 ) {
	$paged_num = max( 1, (int) get_query_var( 'page' ) );
}

$archive_max_pages = (int) $wp_query->max_num_pages;
?>

<main id="blog-archive" class="blog-archive blog-archive--search">
	<header class="blog-archive__hero">
		<div class="container">
			<div class="blog-archive__hero-inner">
				<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) : ?>
					<div class="blog-archive__breadcrumbs"><?php rank_math_the_breadcrumbs(); ?></div>
				<?php elseif ( function_exists( 'yoast_breadcrumb' ) ) : ?>
					<div class="blog-archive__breadcrumbs"><?php yoast_breadcrumb( '', '' ); ?></div>
				<?php endif; ?>
				<h1 class="blog-archive__title"><?php echo esc_html( $page_title ); ?></h1>
				<p class="blog-archive__tagline">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: number of posts found */
							_n( '%s result found.', '%s results found.', $found, 'dwm-lnb' ),
							number_format_i18n( $found )
						)
					);
					?>
				</p>
			</div>
		</div>
	</header>

	<section class="blog-archive__list" aria-label="<?php echo esc_attr( $page_title ); ?>">
		<div class="container">
			<div class="blog-archive__toolbar blog-archive__toolbar--search-only">
				<form class="blog-archive__search-form" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
					<label class="screen-reader-text" for="blog-archive-search"><?php esc_html_e( 'Search blog posts', 'dwm-lnb' ); ?></label>
					<span class="blog-archive__search-icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" stroke="currentColor" stroke-width="1.75"/><path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"/></svg>
					</span>
					<input
						type="search"
						id="blog-archive-search"
						class="blog-archive__search-input"
						name="s"
						autocomplete="off"
						placeholder="<?php esc_attr_e( 'Search articles…', 'dwm-lnb' ); ?>"
						value="<?php echo esc_attr( $q ); ?>"
					/>
				</form>
			</div>

			<div id="blog-archive-results" class="row blog-archive__grid g-4">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'blog-card' );
					endwhile;
				else :
					?>
					<div class="col-12">
						<p class="blog-archive__empty blog-archive__empty--inline"><?php esc_html_e( 'No posts matched your search.', 'dwm-lnb' ); ?></p>
					</div>
					<?php
				endif;
				?>
			</div>
			<div id="blog-archive-pagination" class="blog-archive__pagination">
				<?php
				if ( $archive_max_pages > 1 ) {
					echo dwm_lnb_blog_archive_pagination_html( $archive_max_pages, $paged_num, false );
				}
				?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();

<?php
/**
 * Blog posts index (e.g. /blog when a static front page is set).
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

get_header();

$dwm_blog_main = is_home() && ! is_front_page();

$posts_page_id = (int) get_option( 'page_for_posts' );
$page_title    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'dwm-lnb' );
$page_intro    = '';

// Use queried term for category/tag so title/intro match; resolve from query vars / URL if core query is wrong.
$qo = get_queried_object();
if ( function_exists( 'dwm_lnb_resolve_blog_archive_term' ) ) {
	$resolved_term = dwm_lnb_resolve_blog_archive_term( $qo );
	if ( $resolved_term instanceof WP_Term ) {
		$qo = $resolved_term;
	}
}
if ( $qo instanceof WP_Term && in_array( $qo->taxonomy, array( 'category', 'post_tag' ), true ) ) {
	$page_title = $qo->name;
	$desc       = term_description( $qo->term_id, $qo->taxonomy );
	$page_intro = ( is_string( $desc ) && '' !== $desc ) ? $desc : '';
} elseif ( $dwm_blog_main && $posts_page_id ) {
	$posts_page_obj = get_post( $posts_page_id );
	if ( $posts_page_obj && $posts_page_obj->post_excerpt ) {
		$page_intro = apply_filters( 'the_excerpt', $posts_page_obj->post_excerpt );
	}
}

$blog_categories = array();
if ( $dwm_blog_main ) {
	$blog_categories = get_categories(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);
}

$blog_archive_main_classes = array( 'blog-archive' );
if ( $qo instanceof WP_Term && 'category' === $qo->taxonomy ) {
	$blog_archive_main_classes[] = 'blog-archive--tax-category';
} elseif ( $qo instanceof WP_Term && 'post_tag' === $qo->taxonomy ) {
	$blog_archive_main_classes[] = 'blog-archive--tax-tag';
}

$posts_page_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );

global $wp_query;

$paged_num = (int) get_query_var( 'paged' );
if ( $paged_num < 1 ) {
	$paged_num = (int) get_query_var( 'page' );
}
if ( $paged_num < 1 ) {
	$paged_num = 1;
}

/*
 * Category/tag archives: run a dedicated query for posts in this term. Some plugins alter the main
 * query on taxonomy archives so have_posts() is empty even when posts exist — that yielded a blank grid.
 */
$blog_archive_loop_query = null;
$is_blog_tax_archive     = ( ! $dwm_blog_main && $qo instanceof WP_Term && in_array( $qo->taxonomy, array( 'category', 'post_tag' ), true ) );

if ( $is_blog_tax_archive ) {
	$ppp       = max( 1, min( 100, (int) get_option( 'posts_per_page', 12 ) ) );
	$tax_qargs = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $ppp,
		'paged'               => $paged_num,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => false,
	);
	if ( 'category' === $qo->taxonomy ) {
		$tax_qargs['cat'] = (int) $qo->term_id;
	} else {
		$tax_qargs['tag_id'] = (int) $qo->term_id;
	}
	$blog_archive_loop_query = new WP_Query( $tax_qargs );
}
?>

<main id="blog-archive" class="<?php echo esc_attr( implode( ' ', $blog_archive_main_classes ) ); ?>" data-blog-archive-mode="<?php echo $dwm_blog_main ? 'main' : 'taxonomy'; ?>">
	<header class="blog-archive__hero">
		<div class="container">
			<div class="blog-archive__hero-inner">
				<?php if ( function_exists( 'rank_math_the_breadcrumbs' ) ) : ?>
					<div class="blog-archive__breadcrumbs"><?php rank_math_the_breadcrumbs(); ?></div>
				<?php elseif ( function_exists( 'yoast_breadcrumb' ) ) : ?>
					<div class="blog-archive__breadcrumbs"><?php yoast_breadcrumb( '', '' ); ?></div>
				<?php endif; ?>
				<h1 class="blog-archive__title"><?php echo esc_html( $page_title ); ?></h1>
				<?php if ( $page_intro ) : ?>
					<div class="blog-archive__intro"><?php echo wp_kses_post( $page_intro ); ?></div>
				<?php else : ?>
					<p class="blog-archive__tagline">Tips, inspiration, and stories for your celebration.</p>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<section class="blog-archive__list" aria-label="<?php echo esc_attr( $page_title ); ?>">
		<div class="container">
			<?php if ( $dwm_blog_main ) : ?>
			<div class="blog-archive__toolbar">
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
						value=""
					/>
				</form>
				<nav class="blog-archive__cats" aria-label="<?php esc_attr_e( 'Filter by category', 'dwm-lnb' ); ?>">
					<button type="button" class="blog-archive__cat-btn is-active" data-cat="0"><?php esc_html_e( 'All', 'dwm-lnb' ); ?></button>
					<?php foreach ( $blog_categories as $cat ) : ?>
						<button type="button" class="blog-archive__cat-btn" data-cat="<?php echo (int) $cat->term_id; ?>"><?php echo esc_html( $cat->name ); ?></button>
					<?php endforeach; ?>
				</nav>
			</div>
			<?php else : ?>
			<div class="blog-archive__toolbar blog-archive__toolbar--taxonomy">
				<p class="blog-archive__back">
					<a href="<?php echo esc_url( $posts_page_url ); ?>"><?php esc_html_e( '← All articles', 'dwm-lnb' ); ?></a>
				</p>
				<form class="blog-archive__search-form" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
					<label class="screen-reader-text" for="blog-archive-search-tax"><?php esc_html_e( 'Search blog posts', 'dwm-lnb' ); ?></label>
					<span class="blog-archive__search-icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" stroke="currentColor" stroke-width="1.75"/><path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"/></svg>
					</span>
					<input
						type="search"
						id="blog-archive-search-tax"
						class="blog-archive__search-input"
						name="s"
						autocomplete="off"
						placeholder="<?php esc_attr_e( 'Search articles…', 'dwm-lnb' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
					/>
				</form>
			</div>
			<?php endif; ?>

			<?php
			$loop_q            = $blog_archive_loop_query ? $blog_archive_loop_query : $wp_query;
			$archive_max_pages = (int) $loop_q->max_num_pages;
			if ( ! $blog_archive_loop_query ) {
				rewind_posts();
			}
			?>
			<div id="blog-archive-results" class="row blog-archive__grid g-4">
				<?php
				if ( $loop_q->have_posts() ) :
					while ( $loop_q->have_posts() ) :
						$loop_q->the_post();
						get_template_part( 'template-parts/content', 'blog-card' );
					endwhile;
				else :
					?>
					<div class="col-12">
						<p class="blog-archive__empty blog-archive__empty--inline"><?php esc_html_e( 'No posts found.', 'dwm-lnb' ); ?></p>
					</div>
					<?php
				endif;
				if ( $blog_archive_loop_query ) {
					wp_reset_postdata();
				}
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

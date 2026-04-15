<?php
/**
 * Last-resort template. Load blog-archive for category/tag when the main query is broken
 * (is_category() false, empty queried object) — detection also uses query vars + REQUEST_URI.
 */
if ( ! is_admin() ) {
	$tpl = locate_template( 'template-parts/blog-archive.php', false, false );
	if ( $tpl ) {
		$use_blog = is_category() || is_tag();
		if ( ! $use_blog && function_exists( 'dwm_lnb_is_blog_category_or_tag_archive' ) ) {
			$use_blog = dwm_lnb_is_blog_category_or_tag_archive();
		}
		if ( ! $use_blog && function_exists( 'dwm_lnb_resolve_blog_archive_term' ) ) {
			$use_blog = ( dwm_lnb_resolve_blog_archive_term() !== null );
		}
		if ( $use_blog ) {
			load_template( $tpl, false );
			return;
		}
	}
}

get_header();
?>
<main id="primary" class="site-main container py-4">
<?php
if ( have_posts() ) {
	echo '<div class="row">';
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', 'blog-card' );
	}
	echo '</div>';
	the_posts_navigation();
} else {
	echo '<p>' . esc_html__( 'No content matched your request.', 'dwm-lnb' ) . '</p>';
}
?>
</main>
<?php
get_footer();

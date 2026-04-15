<?php
/**
 * Post category archive — same layout as the tag archive and main blog index.
 * The template_include filter in functions.php also loads template-parts/blog-archive.php
 * so category URLs always get the blog grid even if this file is bypassed.
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

$tpl = locate_template( 'template-parts/blog-archive.php', false, false );
if ( $tpl ) {
	load_template( $tpl, false );
	return;
}

get_header();
?>
<main id="blog-archive" class="blog-archive blog-archive--tax-category">
	<div class="container py-5">
		<p><?php esc_html_e( 'The blog archive template is missing. Add template-parts/blog-archive.php to the theme.', 'dwm-lnb' ); ?></p>
	</div>
</main>
<?php
get_footer();

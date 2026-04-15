<?php
/**
 * Post tag archive — same layout as category archives and the main blog index.
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
<main id="blog-archive" class="blog-archive blog-archive--tax-tag">
	<div class="container py-5">
		<p><?php esc_html_e( 'The blog archive template is missing. Add template-parts/blog-archive.php to the theme.', 'dwm-lnb' ); ?></p>
	</div>
</main>
<?php
get_footer();

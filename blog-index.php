<?php
/**
 * Blog posts index (e.g. /blog).
 * Loaded via template_include so it wins over Page templates on the Posts page.
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

$tpl = locate_template( 'template-parts/blog-archive.php', false, false );
if ( $tpl ) {
	require $tpl;
}

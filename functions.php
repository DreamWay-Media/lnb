<?php
// General
add_theme_support('post-thumbnails');
add_theme_support( 'custom-logo' );
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'title-tag' );

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'dwm-lnb', get_stylesheet_directory() . '/languages' );
	},
	1
);


function dreamway_custom_logo_setup() {
	$defaults = array(
		'height'               => 95,
		'width'                => 222,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => false, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'dreamway_custom_logo_setup' );


/**
 * Compile app.less only when the option is on and the source is newer than app.css (avoids compiling every request).
 */
add_action( 'init', 'less_compile', 5 );
function less_compile() {
	if ( (int) get_option( 'less_status', 1 ) !== 1 ) {
		return;
	}
	if ( apply_filters( 'dwm_lnb_skip_less_compile', false ) ) {
		return;
	}
	$dir  = dirname( __FILE__ );
	$less = $dir . '/css/app.less';
	$css  = $dir . '/css/app.css';
	if ( ! is_readable( $less ) ) {
		return;
	}
	if ( file_exists( $css ) && filemtime( $css ) >= filemtime( $less ) ) {
		return;
	}
	$lock_path = $dir . '/css/.less-compile.lock';
	$lock_fp   = fopen( $lock_path, 'cb' );
	if ( ! $lock_fp ) {
		return;
	}
	if ( ! flock( $lock_fp, LOCK_EX | LOCK_NB ) ) {
		fclose( $lock_fp );
		return;
	}
	require_once $dir . '/css/lessc.inc.php';
	$compiler = new lessc();
	$compiler->setPreserveComments( true );
	try {
		$compiler->setFormatter( 'compressed' );
		$compiler->compileFile( $less, $css );
	} catch ( \Exception $e ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'dwm-lnb LESS compile error: ' . $e->getMessage() );
		}
	}
	flock( $lock_fp, LOCK_UN );
	fclose( $lock_fp );
}

add_action('init', 'sidebars');
function sidebars() {	
  register_sidebar(
		array(
			'name'          => 'logo',
			'id'            => 'logo',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'top_ribbon_right',
			'id'            => 'top_ribbon_right',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'top_ribbon_left',
			'id'            => 'top_ribbon_left',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'header info',
			'id'            => 'header_info',
			'description'   => 'social links',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'instagram feed',
			'id'            => 'instagram_feed',
			'description'   => 'Instagram on Homepage',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'shop',
			'id'            => 'shop',
			'description'   => 'social links',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'footer1',
			'id'            => 'footer1',
			'description'   => 'footer logo',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'footer2',
			'id'            => 'footer2',
			'description'   => 'footer nav',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'footer3',
			'id'            => 'footer3',
			'description'   => 'footer contact',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
  register_sidebar(
		array(
			'name'          => 'footer4',
			'id'            => 'footer4',
			'description'   => 'footer socials',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Blog post sidebar', 'dwm-lnb' ),
			'id'            => 'single_post_sidebar',
			'description'   => __( 'Shown beside single blog posts. Add Recent Posts, Categories, newsletter HTML, etc.', 'dwm-lnb' ),
			'before_widget' => '<section id="%1$s" class="single-sidebar__widget widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="single-sidebar__widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

/**
 * Echo a Polylang-registered string, or a plain fallback when Polylang is inactive.
 *
 * @param string $polylang_string String name passed to pll_e().
 * @param string $fallback        Visible text if Polylang is unavailable.
 */
function dwm_lnb_pll_e( $polylang_string, $fallback = '' ) {
	if ( function_exists( 'pll_e' ) ) {
		pll_e( $polylang_string );
	} elseif ( $fallback !== '' ) {
		echo esc_html( $fallback );
	} else {
		echo esc_html( $polylang_string );
	}
}

/**
 * Page ID for homepage ACF field groups (defaults to static front page if it uses home.php, else 68).
 *
 * @return int
 */
function dwm_lnb_home_acf_page_id() {
	$fallback = 68;
	$front    = (int) get_option( 'page_on_front' );
	if ( $front > 0 ) {
		$tpl = get_page_template_slug( $front );
		if ( is_string( $tpl ) && 'home.php' === $tpl ) {
			$fallback = $front;
		}
	}
	return (int) apply_filters( 'dwm_lnb_home_acf_page_id', $fallback );
}

/**
 * ACF get_field wrapper — returns null if ACF is inactive.
 *
 * @param string   $selector Field name.
 * @param int|bool $post_id  Post ID or false for current post.
 * @return mixed|null
 */
function dwm_lnb_get_field( $selector, $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	return get_field( $selector, $post_id );
}

function get_archive_by_year_and_month( $atts = array() ) {
	global $wpdb;
	$rueckgabe = '';
	// Single query for year/month pairs (avoids N+1 per year).
	$rows = $wpdb->get_results(
		"SELECT YEAR(post_date) AS y, MONTH(post_date) AS m
		FROM $wpdb->posts
		WHERE post_type = 'post' AND post_status = 'publish'
		GROUP BY YEAR(post_date), MONTH(post_date)
		ORDER BY YEAR(post_date) DESC, MONTH(post_date) ASC"
	);
	if ( ! $rows ) {
		return $rueckgabe;
	}
	$by_year = array();
	foreach ( $rows as $row ) {
		$y = (int) $row->y;
		$m = (int) $row->m;
		if ( ! isset( $by_year[ $y ] ) ) {
			$by_year[ $y ] = array();
		}
		$by_year[ $y ][] = $m;
	}
	$rueckgabe = '<ul>';
	foreach ( $by_year as $year => $months ) {
		$year = (int) $year;
		$rueckgabe .= '<li class="jahr"><a href="' . esc_url( get_year_link( $year ) ) . '">' . $year . '</a>';
		$rueckgabe .= '<ul class="monthlist">';
		foreach ( $months as $month ) {
			$date_obj   = DateTime::createFromFormat( '!m', (string) $month );
			$month_name = $date_obj ? $date_obj->format( 'F' ) : (string) $month;
			$rueckgabe .= '<li class="month"><a href="' . esc_url( get_month_link( $year, $month ) ) . '">' . esc_html( $month_name ) . '</a></li>';
		}
		$rueckgabe .= '</ul>';
		$rueckgabe .= '</li>';
	}
	$rueckgabe .= '</ul>';
	return $rueckgabe;
}

add_action( 'admin_init', 'less_register_settings' );
function less_register_settings() {
	register_setting(
		'general',
		'less_status',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'dwm_lnb_sanitize_less_status',
			'default'           => '1',
		)
	);
	add_settings_field(
		'less_status',
		'<label>' . esc_html__( 'LESS CSS Compiler Status', 'dwm-lnb' ) . '</label>',
		'less_settings_fields_html',
		'general'
	);
}

/**
 * @param mixed $value Raw setting.
 * @return string '0' or '1'
 */
function dwm_lnb_sanitize_less_status( $value ) {
	$v = (string) $value;
	return in_array( $v, array( '0', '1' ), true ) ? $v : '1';
}

function less_settings_fields_html() {
	$value = get_option( 'less_status', '1' );
	echo '<fieldset>';
	if ( (string) $value === '0' ) {
		echo '<label><input type="radio" name="less_status" value="1" /> <span>Enable</span></label><br>';
		echo '<label><input type="radio" name="less_status" value="0" checked="checked" /> <span>Disable</span></label><br>';
	} else {
		echo '<label><input type="radio" name="less_status" value="1" checked="checked" /> <span>Enable</span></label><br>';
		echo '<label><input type="radio" name="less_status" value="0" /> <span>Disable</span></label><br>';
	}
	echo '</fieldset>';
}

// Register Styles and Scripts
if ( !function_exists( 'register_styles_scripts' ) ) :
function register_styles_scripts() {
	$theme_uri = get_stylesheet_directory_uri();
    // Styles (stylesheet: child theme can override vendor CSS)
    wp_register_style( 'bootstrap', $theme_uri . '/css/bootstrap.min.css', array(), '5.3' );
    wp_register_style( 'owl', $theme_uri . '/css/owl.carousel.min.css', array(), '1.8.1' );
    wp_register_style( 'owl-theme', $theme_uri . '/css/owl.theme.default.min.css', array(), '1.8.1' );
    //wp_register_style( 'app'    , get_template_directory_uri() . '/css/app_'.get_locale().'.css', array(), '1.0.0' );
    $app_css_path = get_stylesheet_directory() . '/css/app.css';
    $app_css_ver  = file_exists( $app_css_path ) ? (string) filemtime( $app_css_path ) : '1.0.0';
    wp_register_style( 'app', get_stylesheet_directory_uri() . '/css/app.css', array(), $app_css_ver );

    $theme_dir = get_stylesheet_directory();
    // WordPress core jQuery (with jquery-migrate) — best compatibility with WooCommerce and plugins.
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/vendor/bootstrap.js', array( 'jquery' ), '5.3', true );
    wp_register_script( 'owl', get_stylesheet_directory_uri() . '/js/vendor/owl.carousel.min.js', array( 'jquery' ), '1.8.1', true );
    $app_ver = file_exists( $theme_dir . '/js/app.js' ) ? (string) filemtime( $theme_dir . '/js/app.js' ) : '1.0.1';
    wp_register_script( 'app', get_stylesheet_directory_uri() . '/js/app.js', array( 'jquery', 'owl', 'bootstrap' ), $app_ver, true );

    // Load'em All
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'owl' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'app' );

    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'owl' );
    wp_enqueue_script( 'app' );
}
add_action( 'wp_enqueue_scripts', 'register_styles_scripts', 100 );
endif;

/**
 * Google Analytics (gtag) — output once via wp_head.
 * If PixelYourSite (or another plugin) already loads the same GA4 ID, disable the duplicate:
 * add_filter( 'dwm_lnb_output_theme_gtag', '__return_false' );
 * With PixelYourSite active the theme skips this by default; force theme gtag: add_filter( 'dwm_lnb_skip_theme_gtag_when_pys_active', '__return_false' );
 *
 * Set the measurement ID via wp-config.php: define( 'DWM_LNB_GA_MEASUREMENT_ID', 'G-XXXXXXXXXX' );
 * or add_filter( 'dwm_lnb_ga_measurement_id', fn () => 'G-XXXXXXXXXX' ); — no ID is output by default.
 */
if ( ! function_exists( 'dwm_lnb_output_theme_gtag' ) ) :
function dwm_lnb_output_theme_gtag() {
	if ( is_admin() || ! apply_filters( 'dwm_lnb_output_theme_gtag', true ) ) {
		return;
	}
	// PixelYourSite also injects tags; loading gtag here too can duplicate GA and confuse minifiers (Unexpected token '<').
	if ( defined( 'PYS_FREE_VERSION' ) && apply_filters( 'dwm_lnb_skip_theme_gtag_when_pys_active', true ) ) {
		return;
	}
	$default_ga     = ( defined( 'DWM_LNB_GA_MEASUREMENT_ID' ) && is_string( DWM_LNB_GA_MEASUREMENT_ID ) ) ? DWM_LNB_GA_MEASUREMENT_ID : '';
	$measurement_id = apply_filters( 'dwm_lnb_ga_measurement_id', $default_ga );
	if ( ! is_string( $measurement_id ) || ! preg_match( '/^G-[A-Z0-9]+$/i', $measurement_id ) ) {
		return;
	}
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $measurement_id ); ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo esc_js( $measurement_id ); ?>');
</script>
	<?php
}
endif;
add_action( 'wp_head', 'dwm_lnb_output_theme_gtag', 99 );

/**
 * Rank Math: turn off Analytics “frontend stats” (admin-bar script that calls /wp-json/rankmath/v1/an/post/{id}).
 * LiteSpeed/WP Rocket “delay JS” often runs that script before `var rankMath = …` in the footer → objectID is undefined and the REST URL becomes …/post/undefined (404).
 * Analytics in wp-admin is unchanged. Re-enable the bar: remove this filter or use add_filter( 'rank_math/analytics/frontend_stats', '__return_true', 100 );
 */
add_filter( 'rank_math/analytics/frontend_stats', '__return_false', 99 );

/**
 * Force blog archive layout on the Posts page.
 * Otherwise WordPress may use page.php or a Page template instead of home.php.
 */
if ( ! function_exists( 'dwm_lnb_template_blog_index' ) ) :
function dwm_lnb_template_blog_index( $template ) {
	if ( is_admin() ) {
		return $template;
	}
	if ( ! is_home() || is_front_page() ) {
		return $template;
	}
	$blog_tpl = locate_template( array( 'blog-index.php' ) );
	if ( $blog_tpl ) {
		return $blog_tpl;
	}
	return $template;
}
endif;
add_filter( 'template_include', 'dwm_lnb_template_blog_index', 99 );

/**
 * Resolve the category or post_tag term for the current request when conditional tags / queried object fail
 * (e.g. index.php + empty main query, or aggressive pre_get_posts). Used by blog-archive and template detection.
 *
 * @param WP_Term|WP_Post|WP_Post_Type|null $current_qo Optional value from get_queried_object().
 * @return WP_Term|null
 */
if ( ! function_exists( 'dwm_lnb_resolve_blog_archive_term' ) ) :
	function dwm_lnb_resolve_blog_archive_term( $current_qo = null ) {
		if ( is_admin() ) {
			return null;
		}
		if ( $current_qo instanceof WP_Term && in_array( $current_qo->taxonomy, array( 'category', 'post_tag' ), true ) ) {
			return $current_qo;
		}
		$qo = get_queried_object();
		if ( $qo instanceof WP_Term && in_array( $qo->taxonomy, array( 'category', 'post_tag' ), true ) ) {
			return $qo;
		}
		$cat_id = (int) get_query_var( 'cat' );
		if ( $cat_id > 0 ) {
			$t = get_term( $cat_id, 'category' );
			if ( $t && ! is_wp_error( $t ) ) {
				return $t;
			}
		}
		$tag_id = (int) get_query_var( 'tag_id' );
		if ( $tag_id > 0 ) {
			$t = get_term( $tag_id, 'post_tag' );
			if ( $t && ! is_wp_error( $t ) ) {
				return $t;
			}
		}
		$cslug = get_query_var( 'category_name' );
		if ( is_string( $cslug ) && $cslug !== '' ) {
			$t = get_term_by( 'slug', $cslug, 'category' );
			if ( $t && ! is_wp_error( $t ) ) {
				return $t;
			}
		}
		$tslug = get_query_var( 'tag' );
		if ( is_string( $tslug ) && $tslug !== '' ) {
			$t = get_term_by( 'slug', $tslug, 'post_tag' );
			if ( $t && ! is_wp_error( $t ) ) {
				return $t;
			}
		}
		if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
			$path = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
			if ( is_string( $path ) && $path !== '' ) {
				if ( preg_match( '#/(?:category)/([^/]+)/?#', $path, $m ) ) {
					$slug = rawurldecode( $m[1] );
					$t    = get_term_by( 'slug', $slug, 'category' );
					if ( ! $t || is_wp_error( $t ) ) {
						$t = get_term_by( 'slug', sanitize_title( $slug ), 'category' );
					}
					if ( $t && ! is_wp_error( $t ) ) {
						return $t;
					}
				}
				if ( preg_match( '#/(?:tag)/([^/]+)/?#', $path, $m ) ) {
					$slug = rawurldecode( $m[1] );
					$t    = get_term_by( 'slug', $slug, 'post_tag' );
					if ( ! $t || is_wp_error( $t ) ) {
						$t = get_term_by( 'slug', sanitize_title( $slug ), 'post_tag' );
					}
					if ( $t && ! is_wp_error( $t ) ) {
						return $t;
					}
				}
			}
		}
		return null;
	}
endif;

/**
 * True on post category or tag archives. Uses dwm_lnb_resolve_blog_archive_term() when is_category() is false.
 */
if ( ! function_exists( 'dwm_lnb_is_blog_category_or_tag_archive' ) ) :
	function dwm_lnb_is_blog_category_or_tag_archive() {
		if ( is_category() || is_tag() ) {
			return true;
		}
		if ( is_admin() ) {
			return false;
		}
		return dwm_lnb_resolve_blog_archive_term() !== null;
	}
endif;

/**
 * Category & tag archives: render template-parts/blog-archive.php as the main template.
 * Priority 9999 runs after most plugins; index.php uses the same detection as a fallback.
 */
if ( ! function_exists( 'dwm_lnb_template_include_tax_blog_archive' ) ) :
	function dwm_lnb_template_include_tax_blog_archive( $template ) {
		if ( is_admin() ) {
			return $template;
		}
		if ( ! dwm_lnb_is_blog_category_or_tag_archive() ) {
			return $template;
		}
		$path = locate_template( 'template-parts/blog-archive.php', false, false );
		return $path ? $path : $template;
	}
endif;
add_filter( 'template_include', 'dwm_lnb_template_include_tax_blog_archive', 99999 );

/**
 * Body class for blog index (helps target CSS if needed).
 */
if ( ! function_exists( 'dwm_lnb_body_class_blog' ) ) :
function dwm_lnb_body_class_blog( $classes ) {
	if ( is_home() && ! is_front_page() ) {
		$classes[] = 'dwm-blog-index';
	}
	if ( function_exists( 'dwm_lnb_is_blog_category_or_tag_archive' ) && dwm_lnb_is_blog_category_or_tag_archive() ) {
		$classes[] = 'dwm-blog-index';
		$classes[] = 'dwm-blog-tax-archive';
	}
	return $classes;
}
endif;
add_filter( 'body_class', 'dwm_lnb_body_class_blog' );

/**
 * Blog archive: scripts + AJAX filter.
 */
if ( ! function_exists( 'dwm_lnb_enqueue_blog_archive' ) ) :
function dwm_lnb_enqueue_blog_archive() {
	if ( ! is_home() || is_front_page() ) {
		return;
	}
	$path = get_stylesheet_directory() . '/js/blog-archive.js';
	if ( ! file_exists( $path ) ) {
		return;
	}
	wp_enqueue_script(
		'dwm-lnb-blog-archive',
		get_stylesheet_directory_uri() . '/js/blog-archive.js',
		array( 'jquery' ),
		(string) filemtime( $path ),
		true
	);
	wp_localize_script(
		'dwm-lnb-blog-archive',
		'dwmBlogArchive',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'dwm_lnb_blog_filter' ),
		)
	);
}
endif;
add_action( 'wp_enqueue_scripts', 'dwm_lnb_enqueue_blog_archive', 110 );

if ( ! function_exists( 'dwm_lnb_blog_archive_pagination_html' ) ) :
function dwm_lnb_blog_archive_pagination_html( $max_pages, $current, $use_hash_links = false ) {
	$max_pages = (int) $max_pages;
	$current   = max( 1, (int) $current );
	if ( $max_pages < 2 ) {
		return '';
	}
	ob_start();
	echo '<nav class="navigation blog-archive__pagination-nav blog-archive__pagination--ajax" aria-label="Blog pagination">';
	echo '<div class="nav-links">';
	if ( $current > 1 ) {
		$prev = $use_hash_links ? '#' : get_pagenum_link( $current - 1 );
		echo '<a href="' . esc_url( $prev ) . '" class="prev page-numbers" data-page="' . (int) ( $current - 1 ) . '">← Previous</a>';
	}
	for ( $i = 1; $i <= $max_pages; $i++ ) {
		if ( $i === $current ) {
			echo '<span class="page-numbers current" aria-current="page">' . (int) $i . '</span>';
		} else {
			$u = $use_hash_links ? '#' : get_pagenum_link( $i );
			echo '<a href="' . esc_url( $u ) . '" class="page-numbers" data-page="' . (int) $i . '">' . (int) $i . '</a>';
		}
	}
	if ( $current < $max_pages ) {
		$n = $use_hash_links ? '#' : get_pagenum_link( $current + 1 );
		echo '<a href="' . esc_url( $n ) . '" class="next page-numbers" data-page="' . (int) ( $current + 1 ) . '">Next →</a>';
	}
	echo '</div></nav>';
	return ob_get_clean();
}
endif;

if ( ! function_exists( 'dwm_lnb_ajax_filter_posts' ) ) :
function dwm_lnb_ajax_filter_posts() {
	check_ajax_referer( 'dwm_lnb_blog_filter', 'nonce' );

	$cat_id = isset( $_POST['cat'] ) ? (int) $_POST['cat'] : 0;
	$search = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
	$paged  = isset( $_POST['paged'] ) ? max( 1, (int) $_POST['paged'] ) : 1;

	$ppp = max( 1, min( 100, (int) get_option( 'posts_per_page', 12 ) ) );

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $ppp,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => false,
	);

	if ( $cat_id > 0 ) {
		$args['cat'] = $cat_id;
	}

	if ( $search !== '' ) {
		$args['s'] = $search;
	}

	$q = new WP_Query( $args );

	ob_start();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			get_template_part( 'template-parts/content', 'blog-card' );
		}
	} else {
		echo '<div class="col-12"><p class="blog-archive__empty blog-archive__empty--inline">' . esc_html__( 'No posts match your filters.', 'dwm-lnb' ) . '</p></div>';
	}
	wp_reset_postdata();
	$html = ob_get_clean();

	$pagination = dwm_lnb_blog_archive_pagination_html( $q->max_num_pages, $paged, true );

	wp_send_json_success(
		array(
			'html'       => $html,
			'pagination' => $pagination,
			'found'      => (int) $q->found_posts,
		)
	);
}
endif;
add_action( 'wp_ajax_dwm_lnb_filter_posts', 'dwm_lnb_ajax_filter_posts' );
add_action( 'wp_ajax_nopriv_dwm_lnb_filter_posts', 'dwm_lnb_ajax_filter_posts' );

/**
 * LiteSpeed / JS optimizers: keep carousel + theme boot working when "delay JS" is on.
 */
if ( ! function_exists( 'dwm_lnb_exclude_js_delay' ) ) :
function dwm_lnb_exclude_js_delay( $excludes ) {
    if ( ! is_array( $excludes ) ) {
        $excludes = array();
    }
    $base = parse_url( get_stylesheet_directory_uri(), PHP_URL_PATH );
    if ( $base ) {
        $excludes[] = $base . '/js/jquery.min.js';
        $excludes[] = $base . '/js/vendor/jquery.min.js';
        $excludes[] = $base . '/js/vendor/owl.carousel.min.js';
        $excludes[] = $base . '/js/app.js';
        $excludes[] = $base . '/js/blog-archive.js';
    }
    $excludes[] = 'jquery.min.js';
    $excludes[] = 'owl.carousel.min.js';
    $excludes[] = 'app.js';
    $excludes[] = 'blog-archive.js';
	// Rank Math + REST (admin bar analytics): delay/combine breaks inline rankMath config order.
	$excludes[] = 'rank-math';
	$excludes[] = 'seo-by-rank-math';
	$excludes[] = 'admin-bar.js';
	$excludes[] = 'api-fetch';
	$excludes[] = 'wp-api-fetch';
	// PixelYourSite / Facebook (order-sensitive with data layer).
	$excludes[] = 'pixelyoursite';
	$excludes[] = 'pys';
	$excludes[] = 'public.js';
	$excludes[] = 'fbevents';
	$excludes[] = 'botpress';
	$excludes[] = 'dwm-lnb-botpress';
    return $excludes;
}
endif;
add_filter( 'litespeed_optimize_js_excludes', 'dwm_lnb_exclude_js_delay' );

/** WP Rocket — do not delay these scripts (carousel / jQuery). */
add_filter( 'rocket_delay_js_exclusions', 'dwm_lnb_exclude_js_delay' );

/**
 * Mark critical scripts so optimizers that honor data-no-optimize skip defer/combine issues.
 */
if ( ! function_exists( 'dwm_lnb_script_loader_no_optimize' ) ) :
function dwm_lnb_script_loader_no_optimize( $tag, $handle, $src ) {
	$critical = array(
		'jquery',
		'owl',
		'app',
		'bootstrap',
		'dwm-lnb-blog-archive',
		'rank-math',
		'rank-math-analytics-stats',
		'wp-api-fetch',
		'wp-hooks',
		'wp-i18n',
		'wp-element',
		'pys',
		'jquery-bind-first',
		'js-cookie-pys',
		'js-tld',
		'dwm-lnb-botpress-inject',
		'dwm-lnb-botpress-bundle',
	);
    if ( in_array( $handle, $critical, true ) && $src ) {
        if ( strpos( $tag, 'data-no-optimize' ) === false ) {
            $tag = preg_replace( '/^<script\b/i', '<script data-no-optimize="1" data-cfasync="false"', $tag, 1 );
        }
    }
    return $tag;
}
endif;
add_filter( 'script_loader_tag', 'dwm_lnb_script_loader_no_optimize', 10, 3 );

/**
 * Botpress webchat — enqueue so it loads in the footer with other assets (replaces raw tags after wp_footer).
 */
if ( ! function_exists( 'dwm_lnb_enqueue_botpress_webchat' ) ) :
	function dwm_lnb_enqueue_botpress_webchat() {
		if ( is_admin() ) {
			return;
		}
		wp_enqueue_script(
			'dwm-lnb-botpress-inject',
			'https://cdn.botpress.cloud/webchat/v2.3/inject.js',
			array(),
			'2.3',
			true
		);
		wp_enqueue_script(
			'dwm-lnb-botpress-bundle',
			'https://files.bpcontent.cloud/2025/04/07/23/20250407234759-3HTSX1MA.js',
			array( 'dwm-lnb-botpress-inject' ),
			'20250407234759',
			true
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'dwm_lnb_enqueue_botpress_webchat', 200 );

/**
 * Single product: Owl carousel for ACF product videos (script was inline in content-single-product.php).
 */
if ( ! function_exists( 'dwm_lnb_single_product_video_carousel' ) ) :
	function dwm_lnb_single_product_video_carousel() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		$js = <<<'JS'
jQuery(function ($) {
	if (typeof $.fn.owlCarousel !== "function") {
		return;
	}
	$(".single-product div.product .owl-carousel").owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		responsive: {
			0: { items: 1 },
			600: { items: 1 },
			1000: { items: 1 }
		}
	});
});
JS;
		wp_add_inline_script( 'owl', $js, 'after' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'dwm_lnb_single_product_video_carousel', 115 );


// Register Navigation Menus
if ( !function_exists( 'register_dreamway_menus' ) ) :
function register_dreamway_menus() {
    register_nav_menus(
        array(
			'main-menu'    => __( 'Main Menu', 'dwm-lnb' ),
			'shop-menu'    => __( 'shop Menu', 'dwm-lnb' ),
			'contact-menu' => __( 'contact Menu', 'dwm-lnb' ),
			'booking-menu' => __( 'Booking Menu', 'dwm-lnb' ),
			'footer-menu'  => __( 'Footer Menu', 'dwm-lnb' ),
        )
    );
}
add_action( 'init', 'register_dreamway_menus' );
endif;

/**
 * Shared wp_nav_menu args for header menus (submenus + BEM classes for styling).
 */
if ( ! function_exists( 'dwm_lnb_nav_main_menu_args' ) ) :
	function dwm_lnb_nav_main_menu_args() {
		return array(
			'theme_location'  => 'main-menu',
			'container'       => 'div',
			'container_class' => 'nav-menu-container',
			'menu_class'      => 'menu menu--primary',
			'fallback_cb'     => false,
			'depth'           => 4,
		);
	}
endif;
if ( ! function_exists( 'dwm_lnb_nav_booking_menu_args' ) ) :
	function dwm_lnb_nav_booking_menu_args() {
		return array(
			'theme_location'  => 'booking-menu',
			'container'       => 'div',
			'container_class' => 'nav-menu-container nav-menu-container--booking',
			'menu_class'      => 'menu menu--booking',
			'fallback_cb'     => false,
			'depth'           => 4,
		);
	}
endif;


function my_custom_post_type_archive_where( $where, $args ) {
	global $wpdb;
	$post_type = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
	if ( is_array( $post_type ) ) {
		$post_type = ! empty( $post_type[0] ) ? $post_type[0] : 'post';
	}
	$post_type = sanitize_key( (string) $post_type );
	if ( '' === $post_type ) {
		$post_type = 'post';
	}
	return $wpdb->prepare( 'WHERE post_type = %s AND post_status = %s', $post_type, 'publish' );
}
add_filter( 'getarchives_where', 'my_custom_post_type_archive_where', 10, 2 );


// Add WooCommerce support to a theme using
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


/* Woocommerce - Displaying Field in product page for items  */
add_action( 'woocommerce_single_product_summary', 'productimizer_custom_author_field', 15 );

function productimizer_custom_author_field() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
	$size  = get_field( 'size' );
	$space = get_field( 'space_required' );
	if ( ! $size && ! $space ) {
		return;
	}
	echo '<div class="info">';
	if ( $size ) {
		echo '<div class="product_size"><span>' . esc_html__( 'Size:', 'dwm-lnb' ) . '</span>';
		the_field( 'size' );
		echo '</div>';
	}
	if ( $space ) {
		echo '<div class="space_required"><span>' . esc_html__( 'Space required:', 'dwm-lnb' ) . '</span>';
		the_field( 'space_required' );
		echo '</div>';
	}
	echo '</div>';
}


remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10  );
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',25  );


add_filter( 'gettext', 'ds_change_readmore_text', 20, 3 );

function ds_change_readmore_text( $translated_text, $text, $domain ) {
	if ( is_admin() || 'woocommerce' !== $domain || 'Read more' !== $text ) {
		return $translated_text;
	}
	if ( function_exists( 'is_woocommerce' ) && ! is_woocommerce() ) {
		return $translated_text;
	}
	return __( 'Video', 'dwm-lnb' );
}

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Drop empty core/quote blocks (e.g. &lt;blockquote class="wp-block-quote"&gt;&lt;p&gt;&lt;/p&gt;&lt;/blockquote&gt;).
 */
function dwm_lnb_strip_empty_core_quote_block( $block_content, $block ) {
	if ( ! is_array( $block ) || empty( $block['blockName'] ) || 'core/quote' !== $block['blockName'] ) {
		return $block_content;
	}
	$text = wp_strip_all_tags( $block_content );
	if ( '' === trim( $text ) ) {
		return '';
	}
	return $block_content;
}
add_filter( 'render_block', 'dwm_lnb_strip_empty_core_quote_block', 10, 2 );

/**
 * Remove empty quote markup in post content (legacy HTML / edge cases).
 */
function dwm_lnb_strip_empty_wp_block_quote_html( $content ) {
	if ( is_admin() || false === strpos( $content, 'wp-block-quote' ) ) {
		return $content;
	}
	return preg_replace_callback(
		'/<blockquote\b[^>]*\bwp-block-quote\b[^>]*>.*?<\/blockquote>/is',
		static function ( $m ) {
			$text = wp_strip_all_tags( $m[0] );
			return ( '' === trim( $text ) ) ? '' : $m[0];
		},
		$content
	);
}
add_filter( 'the_content', 'dwm_lnb_strip_empty_wp_block_quote_html', 20 );

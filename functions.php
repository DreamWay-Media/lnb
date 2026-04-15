<?php
// General
add_theme_support('post-thumbnails');
add_theme_support( 'custom-logo' );
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'title-tag' );


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


add_action('init', 'less_compile');
function less_compile(){
    if(get_option('less_status',1)==1) {
        $dir = dirname(__FILE__);
        include_once $dir . "/css/lessc.inc.php";
        $less = new lessc;
        $less->setPreserveComments(true);
        try {
            $less->setFormatter("compressed");
            //$less->compileFile($dir . "/css/app_" . get_locale() . ".less", $dir . "/css/app_" . get_locale() . ".css");
            $less->compileFile($dir . "/css/app.less", $dir . "/css/app.css");
        } catch (exception $e) {
            echo "fatal error: " . $e->getMessage();
        }
    }
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
			'name'          => 'copyright',
			'id'            => 'copyright',
			'description'   => 'footer copyright',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

function get_archive_by_year_and_month($atts=array()){
    global $wpdb;
    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC");
    if($years){
        $rueckgabe = '<ul>';
        foreach($years as $year){
            $rueckgabe.='<li class="jahr"><a href="'.get_year_link($year).'">'.$year.'</a>';
            $rueckgabe.='<ul class="monthlist">';
            $months = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_type='post' AND post_status='publish' AND YEAR(post_date) = %d ORDER BY post_date ASC",$year));
            foreach($months as $month){
                $dateObj   = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                $rueckgabe.='<li class="month"><a href="'.get_month_link($year,$month).'">'.$monthName.'</a></li>';
            }
            $rueckgabe.='</ul>';
            $rueckgabe.='</li>';
        }
        $rueckgabe.='</ul>';
    }
    return $rueckgabe;
}
add_filter('admin_init', 'less_register_settings');
function less_register_settings(){
    register_setting('general', 'less_status', 'esc_attr');
    add_settings_field('less_status', '<label>'.__('LESS CSS Compiler Status' , 'less_status' ).'</label>' , 'less_settings_fields_html', 'general');
}
function less_settings_fields_html(){
    $value = get_option( 'less_status', '' );
    echo '<fieldset>';
    if($value == 0){
        echo '<label><input type="radio" name="less_status" value="1" /> <span>Enable</span></label><br>';
        echo '<label><input type="radio" name="less_status" value="0" checked="checked" /> <span>Disable</span></label><br>';
    }else{
        echo '<label><input type="radio" name="less_status" value="1" checked="checked" /> <span>Enable</span></label><br>';
        echo '<label><input type="radio" name="less_status" value="0" /> <span>Disable</span></label><br>';
    }
    echo '</fieldset>';
}

// Register Styles and Scripts
if ( !function_exists( 'register_styles_scripts' ) ) :
function register_styles_scripts() {
    // Styles
    wp_register_style( 'bootstrap'    , get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3' );
    wp_register_style( 'owl'    , get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '1.8.1' );
    wp_register_style( 'owl-theme'    , get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), '1.8.1' );
    //wp_register_style( 'app'    , get_template_directory_uri() . '/css/app_'.get_locale().'.css', array(), '1.0.0' );
    wp_register_style( 'app'    , get_template_directory_uri() . '/css/app.css', array(), '1.0.0' );


    // Scripts
    wp_register_script( 'jQuery3.3.1'    , get_stylesheet_directory_uri() . '/js/vendor/jquery.min.js', array(), '3.6.3', true );
    wp_register_script( 'bootstrap'     , get_stylesheet_directory_uri() . '/js/vendor/bootstrap.js', array(), '5.3', true );
    wp_register_script( 'owl'     , get_stylesheet_directory_uri() . '/js/vendor/owl.carousel.min.js', array(), '1.8.1', true );
    wp_register_script( 'app'     , get_stylesheet_directory_uri() . '/js/app.js', array(), '', true );

    // Load'em All
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'owl' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'app' );

    wp_enqueue_script( 'jQuery3.3.1' );
    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'owl' );
    wp_enqueue_script( 'app' );
}
add_action( 'wp_enqueue_scripts', 'register_styles_scripts' );
endif;


// Register Navigation Menus
if ( !function_exists( 'register_dreamway_menus' ) ) :
function register_dreamway_menus() {
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu' ),
            'shop-menu' => __( 'shop Menu' ),
            'contact-menu' => __( 'contact Menu' ),
            'booking-menu' => __( 'Booking Menu' ),
            'footer-menu' => __( 'Footer Menu' )
        )
    );
}
add_action( 'init', 'register_dreamway_menus' );
endif;


function my_custom_post_type_archive_where($where,$args){
    $post_type  = isset($args['post_type'])  ? $args['post_type']  : 'post';
    $where = "WHERE post_type = '$post_type' AND post_status = 'publish'";
    return $where;
}
add_filter( 'getarchives_where','my_custom_post_type_archive_where',10,2);


// Add WooCommerce support to a theme using
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );


/* Woocommerce - Displaying Field in product page for items  */
add_action( 'woocommerce_single_product_summary', 'productimizer_custom_author_field', 15 );

function productimizer_custom_author_field() { ?>

<?php if(get_field('size')) { ?>
		<div class="info"><div class="product_size"><span>Size:</span><?php the_field('size'); ?></div>

<?php } ?>
    <?php if(get_field('space_required')) { ?>
    <div class="space_required"><span>Space required:</span><?php the_field('space_required'); ?></div>
    <?php } ?> </div> <?php
}


/**
 * Change number of related products output
 */
function woo_related_products_limit() {
  global $product;

	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}


remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10  );
add_action('woocommerce_single_product_summary','woocommerce_template_single_price',25  );


add_filter( 'gettext', 'ds_change_readmore_text', 20, 3 );

function ds_change_readmore_text( $translated_text, $text, $domain ) {
if ( ! is_admin() && $domain === 'woocommerce' && $translated_text === 'Read more') {
$translated_text = 'Video';
}
return $translated_text;
}

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

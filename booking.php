<?php
/*
Template Name: Booking Page
*/
?>
<?php
		
	/*-----Appointment Hero Fields-----*/
	$appointment_title_line_1 = get_field( "appointment_title_line_1", 236 );
	$appointment_title_line_2 = get_field( "appointment_title_line_2", 236 );
	$appointment_desc = get_field( "appointment_desc", 236 );
	$appointment_link_title = get_field( "appointment_link_title", 236 );
	$appointment_link_url = get_field( "appointment_link_url", 236 );
	
	/*-----Alteration Icon Fields-----*/
	$appointment_desc_title_line_1 = get_field( "appointment_desc_title_line_1", 236 );
	$appointment_desc_title_line_2 = get_field( "appointment_desc_title_line_2", 236 );
	$service_1_image = get_field( "service_1_image", 236 );
	$service_1_title = get_field( "service_1_title", 236 );
	$service_1_desc = get_field( "service_1_desc", 236 );
	$service_2_image = get_field( "service_2_image", 236 );
	$service_2_title = get_field( "service_2_title", 236 );
	$service_2_desc = get_field( "service_2_desc", 236 );
	$service_3_image = get_field( "service_3_image", 236 );
	$service_3_title = get_field( "service_3_title", 236 );
	$service_3_desc = get_field( "service_3_desc", 236 );
	$service_4_image = get_field( "service_4_image", 236 );
	$service_4_title = get_field( "service_4_title", 236 );
	$service_4_desc = get_field( "service_4_desc", 236 );
	$service_5_image = get_field( "service_5_image", 236 );
	$service_5_title = get_field( "service_5_title", 236 );
	$service_5_desc = get_field( "service_5_desc", 236 );
	$service_6_image = get_field( "service_6_image", 236 );
	$service_6_title = get_field( "service_6_title", 236 );
	$service_6_desc = get_field( "service_6_desc", 236 );

	$flower_img_base = get_stylesheet_directory_uri() . '/imgs';

?>
<?php get_header('home'); ?>
<main id="booking" class="bookingpage">
	<section class="content booking-section">
		    <div class="flower_left"><img src="<?php echo esc_url( $flower_img_base . '/flower_left.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
		    <div class="flower_right"><img src="<?php echo esc_url( $flower_img_base . '/flower_right.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
		<div class="container">
				<div class="booking-header">
				    <h3 class="about_title_line_1">Hello Beautiful</h3><br>
				    <h3 class="about_title_line_2">Select Appointment Type</h3>
				</div>
				<div class="row">
					<?php
				$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'booking',
        ),
    ),
);

$products_query = new WP_Query( $args );

if ( $products_query->have_posts() ) {
    while ( $products_query->have_posts() ) {
        $products_query->the_post();

        global $product;
        $product_id = get_the_ID();
        $product_title = get_the_title();
        $product_excerpt = get_the_excerpt();
        $product_content = get_the_content();
        $featured_image_url = get_the_post_thumbnail_url( $product_id, 'full' );
        $product_price = get_post_meta( $product_id, '_regular_price', true );

        // Output the product data as desired
        ?>
        <div class="booking-option col-lg-4 col-sm-12">
            <div class="booking-holder">
        <?php

        if ( $featured_image_url ) {
            echo '<img src="' . $featured_image_url . '">';
        }
        ?>
        <div class="booking-content">
        <?php
        echo '<h2 class="booking-title">' . $product_title . '</h2>';
        echo '<p class="booking-speciality">' . $product_excerpt . '</p>';
        echo '<p class="booking-desc">' . $product_content . '</p>';
        woocommerce_template_loop_add_to_cart( array(
            'quantity'   => 1,
            'class'      => 'button',
            'product_id' => $product_id,
        ) ); ?>
        </div>
        </div>
        </div>
        <?php
    }
}

wp_reset_postdata();
					?>
					</div>
		</div>
	</section>
	
</main>

<?php get_footer(); ?>

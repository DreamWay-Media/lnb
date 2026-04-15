<?php get_header(); ?>
<main class="shop-page" id="shop-page">
  <div class="breadcrumb_holder">
    <div class="container">
      <?php
      /**
       * Hook: woocommerce_before_main_content.
       *
       * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
       * @hooked woocommerce_breadcrumb - 20
       * @hooked WC_Structured_Data::generate_website_data() - 30
       */
      do_action( 'woocommerce_before_main_content' )

      ?>
    </div>
    </div>
  <div class="container">
    <div class="row shop-block">
		<div class="page-title">
			<h1>Sample of our best sellers</h1></div>
      <div class="col-lg-12 col-12">
        <div class="shop-items">
          <?php
          if ( woocommerce_product_loop() ) {

            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            

            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
              while ( have_posts() ) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );
              }
            }

            woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
          } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
          }

          /**
           * Hook: woocommerce_after_main_content.
           *
           * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
           */
          do_action( 'woocommerce_after_main_content' );
          ?>
        </div>
      </div>
    </div>
</main>

<?php get_footer(); ?>

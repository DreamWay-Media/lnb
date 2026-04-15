<?php
$paged = (int) get_query_var( 'paged' );
if ( $paged < 1 ) {
	$paged = 1;
}
$ppp      = 24;
$designers = new WP_Query(
	array(
		'post_type'      => 'designers',
		'posts_per_page' => $ppp,
		'paged'          => $paged,
		'post_status'    => 'publish',
	)
);
?>
<?php get_header(); ?>
<main class="specialists-page g-page" id="specialists-page">
  <div class="page-header">
  <div class="breadcrumb_holder">
   </div>
    <div class="container">
      <div class="section-title">
          <h1><?php dwm_lnb_pll_e( 'specialists list title', __( 'Specialists', 'dwm-lnb' ) ); ?></h1>
      </div>
      <div class="row">
        <?php
		if ( $designers->have_posts() ) :
			while ( $designers->have_posts() ) :
				$designers->the_post();
				?>
          <div class="col-lg-3 col-md-6 col-12">
              <div class="specialists-holder">
                <h2 class="title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="info">
                  <div class="item">
                    <?php if ( get_field( 'expertise' ) ) : ?>
                      <span><?php dwm_lnb_pll_e( 'expertise', __( 'Expertise', 'dwm-lnb' ) ); ?></span>
                    <?php the_field( 'expertise' ); ?>
                    <?php endif; ?>
                  </div>
                  <div class="item">
                    <?php if ( get_field( 'position' ) ) : ?>
                      <span><?php dwm_lnb_pll_e( 'position', __( 'Position', 'dwm-lnb' ) ); ?></span>
                    <?php the_field( 'position' ); ?>
                    <?php endif; ?>
                  </div>
                  <div class="item">
                    <?php if ( get_field( 'bio' ) ) : ?>
                      <span><?php dwm_lnb_pll_e( 'bio', __( 'Bio', 'dwm-lnb' ) ); ?></span>
                    <?php the_field( 'bio' ); ?>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="sci">
                  <ul>
                    <?php if ( get_field( 'telegram' ) ) : ?>
                  		<li>
                          <a href="<?php echo esc_url( get_field( 'telegram' ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-telegram"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if ( get_field( 'instagram' ) ) : ?>
                  		<li>
                          <a href="<?php echo esc_url( get_field( 'instagram' ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if ( get_field( 'linkedin' ) ) : ?>
                  		<li>
                          <a href="<?php echo esc_url( get_field( 'linkedin' ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin-in"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if ( get_field( 'twitter' ) ) : ?>
                  		<li>
                          <a href="<?php echo esc_url( get_field( 'twitter' ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-twitter"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if ( get_field( 'website' ) ) : ?>
                      <li>
                          <a href="<?php echo esc_url( get_field( 'website' ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-globe"></i></a>
                      </li>
                    <?php endif; ?>
                	</ul>
                </div>
				  <div class="more"><a href="<?php the_permalink(); ?>"><span><?php dwm_lnb_pll_e( 'read more bio', __( 'Read more', 'dwm-lnb' ) ); ?></span> &gt;&gt;</a></div>
              </div>
          </div>
        <?php
			endwhile;
			wp_reset_postdata();
		else :
			echo '<p class="col-12">' . esc_html__( 'No specialists found.', 'dwm-lnb' ) . '</p>';
		endif;
		?>
      </div>
		<?php
		if ( isset( $designers ) && $designers->max_num_pages > 1 ) {
			echo '<nav class="col-12 navigation specialists-archive__pagination" aria-label="' . esc_attr__( 'Specialists pagination', 'dwm-lnb' ) . '">';
			echo wp_kses_post(
				paginate_links(
					array(
						'total'     => $designers->max_num_pages,
						'current'   => $paged,
						'prev_text' => '&laquo; ' . __( 'Previous', 'dwm-lnb' ),
						'next_text' => __( 'Next', 'dwm-lnb' ) . ' &raquo;',
						'type'      => 'list',
					)
				)
			);
			echo '</nav>';
		}
		?>
    </div>
  </div>
</main>

<?php get_footer(); ?>

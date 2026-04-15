<?php get_header(); ?>
<main class="specialists-page g-page" id="specialists-page">
  <div class="page-header">
  <div class="breadcrumb_holder">
   </div>
    <div class="container">
      <div class="section-title">
          <h1><?php pll_e('specialists list title'); ?></h1>
      </div>
      <div class="row">
        <?php $specialists = get_posts(array('post_type' => 'designers', 'numberposts' => -1)); print_r( $specialists); ?>
        <?php foreach ($specialists as $specialist):?>
          <div class="col-lg-3 col-md-6 col-12">
              <div class="specialists-holder">
                <h2 class="title">
                  <a href="<?php echo get_the_permalink($specialist->ID); ?>"><?php echo get_the_title($specialist->ID); ?></a>
                </h2>
                <div class="info">
                  <div class="item">
                    <?php if(get_field('expertise', $specialist->ID)): ?>
                      <span><?php pll_e('expertise'); ?></span>
                    <?php the_field('expertise', $specialist->ID); ?>
                    <?php endif; ?>
                  </div>
                  <div class="item">
                    <?php if(get_field('position', $specialist->ID)): ?>
                      <span><?php pll_e('position'); ?></span>
                    <?php the_field('position', $specialist->ID); ?>
                    <?php endif; ?>
                  </div>
                  <div class="item">
                    <?php if(get_field('bio', $specialist->ID)): ?>
                      <span><?php pll_e('bio'); ?></span>
                    <?php the_field('bio', $specialist->ID); ?>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="sci">
                  <ul>
                    <?php if(get_field('telegram', $specialist->ID)): ?>
                  		<li>
                          <a href="<?php the_field('telegram', $specialist->ID); ?>" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if(get_field('instagram', $specialist->ID)): ?>
                  		<li>
                          <a href="<?php the_field('instagram', $specialist->ID); ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if(get_field('linkedin', $specialist->ID)): ?>
                  		<li>
                          <a href="<?php the_field('linkedin', $specialist->ID); ?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if(get_field('twitter', $specialist->ID)): ?>
                  		<li>
                          <a href="<?php the_field('twitter', $specialist->ID); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                      </li>
                    <?php endif; ?>
                    <?php if(get_field('website', $specialist->ID)): ?>
                      <li>
                          <a href="<?php the_field('website', $specialist->ID); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                      </li>
                    <?php endif; ?>
                	</ul>
                </div>
				  <div class="more"><a href="<?php echo get_the_permalink($specialist->ID); ?>"><span><?php pll_e('read more bio'); ?></span> >></a></div>
              </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
</main>

<?php get_footer(); ?>

<?php get_header();the_post(); ?>
<main class="single" id="single">
  <div class="breadcrumb_holder">
    <div class="container">
      <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
    </div>
   </div>
   <div class="container">
     <?php the_content(); ?>
   </div>
</main>
<?php get_footer(); ?>

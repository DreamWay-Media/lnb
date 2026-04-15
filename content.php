<?php
/*
Template Name: Blog Content Page
*/
?>
<?php get_header();the_post(); ?>
<main class="blog-content-page g-page" id="blog-listin-page">
   <section class="main-content">
       
		    <div class="flower_left"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/imgs/flower_left.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
		    <div class="flower_right"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/imgs/flower_right.png' ); ?>" alt="" loading="lazy" decoding="async" /></div>
     <div class="container">
         <div class="content-wrapper">
           <?php the_content(); ?>
         </div>
     </div>
   </section>
   <section class="related">
     <div class="container">
         <div class="related-wrapper">
           <h3>Other blog articles</h3>
           
           
           <div class="row">
               <div class="col-lg-3">
                   <div class="related-holder">
                    <figure class="wp-block-image size-full"><img decoding="async" width="962" height="890" src="http://dev.lovenbride.com/wp-content/uploads/2023/02/pexels-transtudios-photography-video-3684519-1-2.png" sizes="(max-width: 962px) 100vw, 962px"></figure>
                    <p><strong>Wedding Dress 101</strong></p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    
                    <div class="btn default">						<a href="https://dev.lovenbride.com/wedding-dress-101/">Read More</a>							</div>
                    </div>
               </div>
               <div class="col-lg-3">
                   <div class="related-holder">
                    <figure class="wp-block-image size-full"><img decoding="async" width="962" height="890" src="http://dev.lovenbride.com/wp-content/uploads/2023/02/pexels-transtudios-photography-video-3684519-1-3.png" sizes="(max-width: 962px) 100vw, 962px"></figure>
                    <p><strong>Wedding Colors and Bridal Party Ideas</strong></p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    
                    <div class="btn default">						<a href="https://dev.lovenbride.com/wedding-colors-and-bridal-party-ideas/">Read More</a>							</div>
                    </div>
               </div>
           </div>
         </div>
     </div>
   </section>
</main>
<?php get_footer(); ?>

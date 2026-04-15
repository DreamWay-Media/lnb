<?php
/**
 * Single blog card for archive & AJAX.
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

$thumb_id = get_post_thumbnail_id();
$cats     = get_the_category();
$primary_cat = ! empty( $cats ) ? $cats[0] : null;
?>
<article <?php post_class( 'col-12 col-md-6 col-lg-4 blog-archive-card-wrap' ); ?>>
	<a href="<?php the_permalink(); ?>" class="blog-archive-card">
		<div class="blog-archive-card__image">
			<?php
			if ( $thumb_id ) {
				echo wp_get_attachment_image(
					$thumb_id,
					'medium_large',
					false,
					array( 'class' => 'blog-archive-card__img' )
				);
			} else {
				echo '<div class="blog-archive-card__placeholder" aria-hidden="true"></div>';
			}
			?>
			<?php if ( $primary_cat ) : ?>
				<span class="blog-archive-card__cat-badge"><?php echo esc_html( $primary_cat->name ); ?></span>
			<?php endif; ?>
		</div>
		<div class="blog-archive-card__body">
			<time class="blog-archive-card__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<h2 class="blog-archive-card__title"><?php the_title(); ?></h2>
			<p class="blog-archive-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
			<span class="blog-archive-card__cta">Read article</span>
		</div>
	</a>
</article>

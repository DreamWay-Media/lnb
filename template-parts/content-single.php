<?php
/**
 * Single post content (used in single-post.php).
 *
 * @package dwm-lnb
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	echo '<div class="single-post__inner">';
	echo get_the_password_form();
	echo '</div>';
	return;
}
?>

<?php if ( has_post_thumbnail() ) : ?>
	<figure class="single-post__thumb">
		<?php
		the_post_thumbnail(
			'large',
			array(
				'class'   => 'single-post__thumb-img',
				'loading' => 'eager',
			)
		);
		?>
	</figure>
<?php endif; ?>

<div class="single-post__inner">
	<header class="single-post__header">
		<?php
		$cats = get_the_category();
		if ( ! empty( $cats ) ) :
			?>
			<p class="single-post__eyebrow">
				<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
			</p>
		<?php endif; ?>

		<h1 class="single-post__title"><?php the_title(); ?></h1>

		<div class="single-post__meta">
			<span class="single-post__meta-item single-post__meta-date">
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</span>
		</div>
	</header>

	<div class="single-post__entry entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="single-post__page-links"><span class="single-post__page-links-label">' . esc_html__( 'Pages:', 'dwm-lnb' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<?php
	$tags = get_the_tags();
	if ( $tags ) :
		?>
		<div class="single-post__tags" role="group" aria-label="<?php esc_attr_e( 'Tags', 'dwm-lnb' ); ?>">
			<span class="single-post__tags-label"><?php esc_html_e( 'Tags', 'dwm-lnb' ); ?></span>
			<div class="single-post__tags-list">
				<?php
				foreach ( $tags as $tag ) {
					echo '<a class="single-post__tag-link" href="' . esc_url( get_tag_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a>';
				}
				?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	$prev = get_previous_post();
	$next = get_next_post();
	if ( $prev || $next ) :
		$pager_mod = '';
		if ( $prev xor $next ) {
			$pager_mod = $prev ? ' single-post__pager--prev-only' : ' single-post__pager--next-only';
		}
		?>
		<nav class="single-post__pager<?php echo esc_attr( $pager_mod ); ?>" aria-label="<?php esc_attr_e( 'Post navigation', 'dwm-lnb' ); ?>">
			<?php if ( $prev ) : ?>
				<a class="single-post__pager-link single-post__pager-link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
					<span class="single-post__pager-dir">
						<span class="single-post__pager-arrow" aria-hidden="true">←</span>
						<?php esc_html_e( 'Previous', 'dwm-lnb' ); ?>
					</span>
					<span class="single-post__pager-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
				</a>
			<?php endif; ?>
			<?php if ( $next ) : ?>
				<a class="single-post__pager-link single-post__pager-link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
					<span class="single-post__pager-dir">
						<?php esc_html_e( 'Next', 'dwm-lnb' ); ?>
						<span class="single-post__pager-arrow" aria-hidden="true">→</span>
					</span>
					<span class="single-post__pager-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
				</a>
			<?php endif; ?>
		</nav>
	<?php endif; ?>

	<?php
	if ( comments_open() || get_comments_number() ) :
		?>
		<section class="single-post__comments">
			<?php comments_template(); ?>
		</section>
	<?php endif; ?>
</div>

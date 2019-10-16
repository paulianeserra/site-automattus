<?php
/**
 * Single page content template used for page.php
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 0.0.8
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'onepage-parallax-post' ); ?>>
	<?php if ( ! is_single() && has_post_thumbnail() ) : ?>
		<div class="single-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'onepage-parallax-blogpost-thumb' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
		<?php endif; ?>

	<div class="post-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'onepage-parallax' ),
				'after'  => '</div>',
			)
		);

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
			?>
		</div> <!--  .post-detail -->
	</article>

<?php
/**
 * Template part for displaying posts
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'onepage-parallax-post' ); ?>>
	<?php if ( ! is_single() ) : ?>

	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="single-thumbnail">
			<!-- <a href="<?php //the_permalink(); ?>"> -->
				<?php the_post_thumbnail( 'onepage-parallax-blogpost-thumb' ); ?>
			<!-- </a> -->
			<img src="<?php echo esc_url( the_post_thumbnail_url( 'onepage-parallax-widget-thumb' ) ); ?>" class="bg_img" alt="">
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<div class="post-meta">
		<div class="post-author">
		</div>
		<div class="post-dates">
		</div>
	</div>
	<header class="post-header">
		<?php

		if ( is_single() ) {
				the_title( '<h2 class="entry-title">', '</h2>' );
		} elseif ( is_front_page() && is_home() ) {
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}

		?>
	</header><!-- .post-header -->
		<div class="post-info">
			<h4><?php onepage_parallax_categories(); ?>	<span>  </span></h4>
		</div>
	<?php endif; ?>
	<div class="post-content
	<?php
	if ( is_single() ) {
		echo 'single-post-contents' ;}
?>
">
		<?php
			if ( checked( get_theme_mod( 'onepage_parallax_content_type', 'excerpt' ), 'excerpt', false ) ) :
				the_excerpt();
			else :
				the_content();
			endif;

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'onepage-parallax' ),
				'after'  => '</div>',
			)
		);

		?>

		<?php if ( ! is_singular() ) : ?>

		<footer class="post-footer">

			<?php onepage_parallax_read_more_link(); ?>

			<?php
			if ( comments_open() ) :

				$onepage_parallax_BPCCount_check = get_theme_mod( 'onepage_parallax_BPCCount_visible', true );
				if ( $onepage_parallax_BPCCount_check ) :
				?>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-comments"><i class="far fa-comment" aria-hidden="true"></i> <?php onepage_parallax_post_comment_count(); ?></a>
				<?php
			  endif;
			endif;
			?>
			<hr />
		</footer>

		<?php endif; ?>


	</div><!-- .post-content -->

</article><!-- #post-## -->

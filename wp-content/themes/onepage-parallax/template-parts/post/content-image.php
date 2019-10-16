<?php
/**
* Template part for displaying image posts
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'onepage-parallax-post' ); ?>>
	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
		<div class="single-thumbnail">
			<!-- <a href="<?php the_permalink(); ?>"> -->
			<?php the_post_thumbnail( 'onepage-parallax-blogpost-thumb' ); ?>
			<!-- </a> -->
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<?php if ( ! is_single() ) : ?>

		<?php $onepage_parallax_BPAuthor_visible = get_theme_mod( 'onepage_parallax_BPAuthor_visible', true ); ?>
		<div class="post-meta">
			<?php if ( $onepage_parallax_BPAuthor_visible ) : ?>
				<div class="post-author">
					<?php onepage_parallax_meta_author(); ?>
				</div>
			<?php endif; ?>
			<div class="post-dates">
				<?php onepage_parallax_post_date(); ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="post-info">
		<h4><?php onepage_parallax_categories(); ?>	<span>  </span></h4>
	</div>
	<header class="post-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif ( is_front_page() && is_home() ) {
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header><!-- .post-header -->
	<div class="post-content <?php if ( is_single() ) { echo 'single-post-contents' ;} ?>">
		<?php if ( is_single() ) :

			the_content();
			onepage_parallax_author_bio_for_single();
			onepage_parallax_tags();
			onepage_parallax_pagination_labels();

			else :
				if ( checked( get_theme_mod( 'onepage_parallax_content_type', 'excerpt' ), 'excerpt', false ) ) :
					the_excerpt();
				else :
					the_content();
				endif;
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
							if ( 1 == $onepage_parallax_BPCCount_check ) :
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

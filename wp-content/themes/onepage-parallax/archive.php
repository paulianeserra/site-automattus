<?php
/**
* The template for displaying archive pages.
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

get_header();
?>

<?php
$onepage_parallax_blog_sidebar_position = get_theme_mod( 'onepage_parallax_blog_sidebar', 'right' );
if ( 'left' == $onepage_parallax_blog_sidebar_position || 'right' == $onepage_parallax_blog_sidebar_position ) {
	$onepage_parallax_archive_class = 'col-md-9';
} else {
	$onepage_parallax_archive_class = 'col-12';
}
?>
<div <?php post_class( 'archive-page' ); ?> id="post-<?php the_ID(); ?>" >
	<div class="container-fluid">
		<div class="row">
			<?php if ( 'left' == $onepage_parallax_blog_sidebar_position ) : ?>
				<div class="col-md-3 onepage-parallax-sidebar">
					<?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
				</div>
			<?php endif; ?>

			<div class="<?php echo $onepage_parallax_archive_class; ?>">
				<h2><?php printf( esc_html__( 'Archive', 'onepage-parallax' ) ); ?></h2>
				<?php
				if ( have_posts() ) :

					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'template-parts/post/content', get_post_format() );

					endwhile;

					// Display Pagination.
					onepage_parallax_pagination();

					else :

						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
				</div>

				<?php if ( 'right' == $onepage_parallax_blog_sidebar_position ) : ?>
					<div class="col-md-3 onepage-parallax-sidebar">
						<?php
						if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
							dynamic_sidebar( 'sidebar-widget-area' );
						} else {
							get_sidebar();
						} ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php get_footer(); ?>

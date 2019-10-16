<?php
/**
 * Template for displaying comments.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 0.0.1
 */

	if ( post_password_required() ) {
		return;
	}
	?>

	<div id="comments" class="comments-area">
		<?php if ( have_comments() ) : ?>
				<div class="comments-title">
				<?php echo esc_html__( 'Comments', 'onepage-parallax' ); ?>
				</div>
			<span class="feedback"> <?php esc_html_e( 'Suggestions & feedback', 'onepage-parallax' ); ?></span>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above" class="comment-navigation clearfix" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'onepage-parallax' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&laquo; Older Comments', 'onepage-parallax' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &raquo;', 'onepage-parallax' ) ); ?></div>
				</div>
			</nav>
			<?php endif; ?>

			<ol class="comment-list">
				<?php
					wp_list_comments(
						array(
						'style'      => 'li',
						'short_ping' => true,
						'avatar_size' => 80,
						)
					);
				?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="comment-navigation clearfix" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'onepage-parallax' ); ?></h2>
				<div class="nav-links">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&laquo; Older Comments', 'onepage-parallax' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &raquo;', 'onepage-parallax' ) ); ?></div>
				</div>
			</nav>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php //esc_html_e( 'Comments are closed.', 'onepage-parallax' ); ?></p>
		<?php endif; ?>
		<?php
		comment_form(
			array(
				'title_reply' => '<span>' . esc_html__( 'Leave a comment', 'onepage-parallax' ) . '</span>',
				'comment_notes_after' => '',
			)
		);
		?>

</div><!-- #comments -->

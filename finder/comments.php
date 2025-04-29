<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package finder
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$style       = finder_get_blog_single_style();
$title_class = 'mb-4 pb-2';
$wrap_class  = 'comments-area pt-4 pb-5';

switch ( $style ) {
	case 'car-finder':
		$title_class .= ' text-light';
		break;
	case 'real-estate':
		$wrap_class = 'comments-area';
	case 'default':
		$title_class .= ' fs-4';

}

?>
<?php if ( have_comments() ) : ?>
	<div class="<?php echo esc_attr( $wrap_class ); ?>" id="comments" aria-label="<?php esc_attr_e( 'Post Comments', 'finder' ); ?>">
		<h3 class="<?php echo esc_attr( $title_class ); ?>">
			<?php
			echo esc_html(
				sprintf(
				/* translators: 1: number of comments, 2: post title */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'finder' ) ),
					number_format_i18n( get_comments_number() )
				)
			);
			?>
		</h3>
		<div class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'      => 'div',
						'short_ping' => true,
						'callback'   => 'finder_comment',
					)
				);
			?>
		</div><!-- .comment-list -->
		<?php
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through.
			?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Comment Navigation Below', 'finder' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'finder' ); ?></span>
				<div class="d-flex justify-content-between">
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'finder' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'finder' ) ); ?></div>
				</div>
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

		if ( ! comments_open() && 0 !== intval( get_comments_number() ) && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments alert alert-warning mb-0"><?php esc_html_e( 'Comments are closed.', 'finder' ); ?></p>
			<?php
		endif;
		?>
	</div>
	<?php
endif;



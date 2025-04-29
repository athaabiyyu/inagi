<?php
/**
 * Template for displayig single finder posts.
 *
 * @package finder
 */

$container_class  = 'container mb-md-4';
$sticky_header    = finder_is_sticky_header();
$has_sidebar = finder_get_blog_single_layout();


if ( $sticky_header ) {
	$container_class = 'container mt-5 pt-5';
}

?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	
	<?php
	/**
	 * Functions hooked into finder_single_post_job_board_demo action.
	 *
	 * @hooked finder_breadcrumb - 5
	 * @hooked finder_single_post_title - 10
	 */
	do_action( 'finder_single_post_job_board_demo' );
		
	/**
	 * Functions hooked into finder_single_post_hero_image_job_board action.
	 *
	 * @hooked finder_single_post_featured_image - 10
	 */
	do_action( 'finder_single_post_hero_image_job_board' );
	?>
		<div class = "row mt-4 pt-3">
		<?php if ( 'full-width' !== $has_sidebar ) {
			?><div class="col-lg-8"><?php
		} else {
			?><div class = "col-lg-10 mx-auto"><?php
		}
		/**
		 * Functions hooked into finder_single_post_body_job_board_demo action.
		 *
		 * @hooked finder_single_post_meta - 10
		 * @hooked finder_single_post_excerpt - 20
		 * @hooked finder_single_post_content - 30
		 */
		do_action( 'finder_single_post_body_job_board_demo' );
		?>
		<?php if ( finder_single_post_is_share_enabled() || has_tag() ) : ?>
			<div class="pt-4">
				<div class="d-md-flex align-items-center justify-content-between border-top pt-4">
					<?php
					/**
					 * Functions hooked into finder_single_post_footer_job_board_demo action.
					 *
					 * @hooked finder_single_post_tag - 10
					 * @hooked finder_single_post_share - 20
					 */
					do_action( 'finder_single_post_footer_job_board_demo' );
					?>
						
				</div>
			</div>
		<?php endif; ?>
		<?php
		/**
		 * Functions hooked into finder_single_post_after_footer_job_board_demo action.
		 *
		 * @hooked finder_single_post_comment - 10
		 */
		do_action( 'finder_single_post_after_footer_job_board_demo' );
		?>
		</div>
		<?php finder_blog_single_sidebar(); ?>
	</div>
	<?php
		/**
		 * Functions hooked into finder_single_post_realted_post_job_board_demo action.
		 *
		 * @hooked finder_single_post_recent_posts- 10
		 */
		do_action( 'finder_single_post_realted_post_job_board_demo' );
	?>
</div>
<?php
/**
 * Functions hooked into finder_single_post_comment_form_job_board_demo action.
 *
 * @hooked finder_single_post_comment_form - 10
 */
do_action( 'finder_single_post_comment_form_job_board_demo' );
?>

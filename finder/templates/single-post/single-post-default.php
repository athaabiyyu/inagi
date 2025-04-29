<?php
/**
 * Default Single Post Template.
 *
 * @package finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_template_part( 'templates/global/page', 'header' );
$style = finder_get_blog_single_style();
$img_class = 'mb-4 pb-3 mt-n3';

if ( $style = 'default' ) {
	$img_class .= ' col-lg-9 mx-auto';
}

?>
<div class="container">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="<?php echo esc_attr( $img_class ) ?>">
		<?php the_post_thumbnail( 'full', array( 'class' => 'rounded-3' ) ); ?>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-lg-9 mb-5 mx-auto">
			<div class="space-y-6 mb-0-last-child pb-0-last-child">
				<?php finder_the_single_post_meta( 'default' ); ?>
				<div class="prose entry-content"><?php the_content(); ?></div>
				<?php 
				finder_link_pages();
				$tags_list     = get_the_tag_list( '' );
				$share_enabled = apply_filters( 'finder_single_post_share_enabled', false );

				if ( $tags_list || $share_enabled ) :
					?>
				<div class="tag-and-share"> 
					<div class="d-md-flex align-items-center justify-content-between border-top pt-4">
						<?php if ( $tags_list ) : ?>
							<?php finder_single_post_tags( 'default' ); ?>
						<?php endif; ?>
						<?php if ( $share_enabled ) : ?>
						<div class="d-flex align-items-center">
							<div class="fw-bold text-nowrap pe-1 mb-2"><?php echo esc_html__( 'Share:', 'finder' ); ?></div>
							<div class="d-flex"><a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mb-2 ms-2" href="#" data-bs-toggle="tooltip" title="<?php echo esc_attr('Share with LinkedIn','finder'); ?>" data-bs-original-title="Share with Facebook" aria-label="<?php esc_attr_e( 'Share with LinkedIn ','finder'); ?>"><i class="fi-facebook"></i></a><a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mb-2 ms-2" href="#" data-bs-toggle="tooltip" title="<?php echo esc_attr('Share with LinkedIn','finder'); ?>" data-bs-original-title="Share with Twitter" aria-label="<?php esc_attr_e( 'Share with LinkedIn','finder' ); ?>"><i class="fi-twitter"></i></a><a class="btn btn-icon btn-light-primary btn-xs rounded-circle shadow-sm mb-2 ms-2" href="#" data-bs-toggle="tooltip" title="<?php echo esc_attr('Share with LinkedIn','finder'); ?>" data-bs-original-title="Share with LinkedIn" aria-label="<?php esc_attr_e( 'Share with LinkedIn','finder' ); ?>"><i class="fi-linkedin"></i></a></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php 
				if ( false == ( ( function_exists ('finder_is_hivepress_activated') && finder_is_hivepress_activated() ) || ( function_exists ('finder_is_wp_job_manager_activated') && finder_is_wp_job_manager_activated() ) ) ){
					if ( ! is_attachment() ){
						do_action('finder_single_post_navigation');
					}
				}
				finder_single_post_comment(); ?>
			</div>
		</div>
	</div>
</div>
<?php
finder_single_post_comment_form();


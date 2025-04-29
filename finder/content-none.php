<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package finder
 */

$display_search_form = true;
$sticky_header       = finder_is_sticky_header();
$blog_style          = finder_get_blog_style();

if ( is_home() && current_user_can( 'publish_posts' ) ) {
	$get_started_link = '<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">' . esc_html__( 'Get started here', 'finder' ) . '</a>';
	/* translators: 1: URL */
	$lead                = sprintf( wp_kses( __( 'Ready to publish your first post? %s.', 'finder' ), array( 'a' => array( 'href' => array() ) ) ), $get_started_link );
	$display_search_form = false;
} elseif ( is_search() ) {
	$lead = esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'finder' );
} else {
	$lead = esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'finder' );
}

?>
<div class="no-results not-found">
	<header class="page__header py-5 my-5">
		<div class="container <?php echo esc_attr( $sticky_header ? 'pt-5 pb-lg-4 mt-5 mb-sm-2' : 'mt-4 mb-md-4' ); ?>">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-12 col-12">

					<div class="text-center">
						<h1 class="display-3 <?php echo ( 'car-finder' === $blog_style ) ? 'text-light' : ''; ?> fw-bold"><?php echo esc_html__( 'Nothing Found', 'finder' ); ?></h1>
						<?php if ( isset( $lead ) && ! empty( $lead ) ) : ?>
							<p class="lead <?php echo ( 'car-finder' === $blog_style ) ? 'text-light' : ''; ?> px-8"><?php echo wp_kses_post( $lead ); ?></p>
						<?php endif; ?>
					</div>
					<div class="col-md-8 mx-auto">
					<?php
					if ( isset( $display_search_form ) && $display_search_form ) {
						finder_search_form();
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</header>
</div><!-- .no-results -->

<?php
/**
 * Template to display sidebar blog.
 *
 * @package finder/city-guide
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
	<div class="offcanvas offcanvas-start offcanvas-collapse" id="blog-sidebar">
		<div class="offcanvas-header shadow-sm mb-2">
			<h2 class="h5 offcanvas-title"><?php echo esc_html__( 'Sidebar', 'finder' ); ?></h2>
			<button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
		</div>
		<div class="offcanvas-body">
			<?php dynamic_sidebar( 'sidebar-blog' ); ?>
		</div>
	</div>
<?php endif; ?>

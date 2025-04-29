<?php
/**
 * Blog Control bar.
 *
 * @package finder/real-estate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<!-- Search bar + filters-->
<div class="row gy-3 mb-4 pb-2">
	<div class="col-md-4 order-md-1 order-2">
		<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="position-relative">
				<input class="form-control pe-5" type="text" placeholder="<?php esc_attr_e( 'Search articles by keywords...', 'finder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" required><i class="fi-search position-absolute top-50 end-0 translate-middle-y me-3"></i>
				<input class="form-control form-control-light" type="hidden" value="post" name="post_type">
			</div>
		</form>
	</div>
	<div class="col-md-3 offset-md-5 order-md-2 order-1">
		<div class="d-flex flex-sm-row flex-column align-items-sm-center">
			<label class="d-inline-block me-sm-2 mb-sm-0 mb-2 text-nowrap" for="blog-sidebar-dropdown"><i class="fi-align-left mt-n1 me-2 align-middle opacity-70"></i><?php echo esc_html__( 'Categories:', 'finder' ); ?></label>
			<form action="<?php echo esc_url( home_url() ); ?>" method="get">
				<?php
				wp_dropdown_categories(
					array(
						'class'           => 'form-select',
						'id'              => 'blog-sidebar-dropdown',
						'show_option_all' => esc_html__(
							'All',
							'finder'
						),
					)
				);
				?>
			</form>
			<script>
			/* <![CDATA[ */
			(function() {
				var dropdown = document.getElementById( "blog-sidebar-dropdown" );
				function onCatChange() {
					if ( dropdown.options[ dropdown.selectedIndex ].value >= 0 ) {
						dropdown.parentNode.submit();
					}
				}
				dropdown.onchange = onCatChange;
			})();
			/* ]]> */
			</script>
		</div>
	</div>
</div>

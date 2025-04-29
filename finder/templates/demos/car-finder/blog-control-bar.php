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
<div class="d-lg-flex pt-1 pb-4 mb-3" style="margin-top:-1.25rem;">
	<div class="d-flex mb-3 mb-lg-0 pe-lg-2">
		<div class="d-flex flex-md-row flex-column align-items-md-center flex-grow-1 border-end-lg border-light ps-3 ps-md-2 pe-lg-4 me-lg-4">
			<label class="d-inline-block text-light me-sm-2 mb-md-0 mb-2 text-nowrap" for="blog-sidebar-dropdown"><i class="fi-align-left mt-n1 me-2 align-middle opacity-70"></i><?php echo esc_html__( 'Categories:', 'finder' ); ?></label>
			<form action="<?php echo esc_url( home_url() ); ?>" method="get">
				<?php
				wp_dropdown_categories(
					array(
						'class'           => 'form-select form-select form-select-light me-lg-2',
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
	<div class=" flex-grow-1">
		<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="position-relative">
				<input class="form-control form-control-light" type="text" placeholder="<?php esc_attr_e( 'Search articles by keywords...', 'finder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s"><i class="fi-search position-absolute top-50 end-0 translate-middle-y text-light opacity-70 me-3"></i>
				<input class="form-control form-control-light" type="hidden" value="post" name="post_type">
			</div>
		</form>
	</div>
</div>

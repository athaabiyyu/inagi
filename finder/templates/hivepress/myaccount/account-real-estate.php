<?php
/**
 * Account real estate template.
 *
 * @package Finder
 */

?>
<div class="row">
	<?php
		do_action( 'finder_hivepress_user_account_before' );
	?>
	<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
		<div class="card card-body border-0 shadow-sm pb-1 me-lg-1">
			<?php
				/**
				 * Functions hooked into finder_hivepress_myaccount_sidebar_real_estate_ action.
				 *
				 * @hooked Sidebar_author_meta
				 * @hooked Sidebar_listing
				 */
				do_action( 'finder_hivepress_user_account' );
			?>
		</div>
	</aside>
	<div class="col-lg-8 col-md-7 mb-5">
		<?php
			/**
			 * Functions hooked into finder_hivepress_myaccount_content_real_estate_ action.
			 *
			 * @hooked
			 * @hooked
			 */
			do_action( 'finder_hivepress_user_account_after' );
		?>
	</div>
</div>

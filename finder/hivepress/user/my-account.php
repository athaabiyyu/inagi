<?php
/**
 * The Template for my account
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?><div class="container pt-5 pb-lg-4 mt-5 mb-sm-2">
	<?php
		/**
		 * Functions hooked in to finder_hivepress_archive_listings action
		 *
		 * @hooked finder_hivepress_listings - 10
		 */
		do_action( 'finder_hivepress_view_account' );
	?>
</div>
<?php

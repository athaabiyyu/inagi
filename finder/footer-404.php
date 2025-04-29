<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php finder_content_bottom(); ?>
	</div><!-- #content -->
<?php
	finder_content_after();

?>
	</div><!-- #page -->
<?php
	finder_body_bottom();
	wp_footer();
?>
	</body>
</html>

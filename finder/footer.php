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
</div><!-- #page -->
<?php
	finder_content_after();

	finder_footer_before();

	finder_footer();

	finder_footer_after();

	finder_body_bottom();

	wp_footer();
?>
	</body>
</html>

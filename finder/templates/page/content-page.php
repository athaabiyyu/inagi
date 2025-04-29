<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package finder
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to finder_page add_action
	 *
	 * @hooked finder_page_header          - 10
	 * @hooked finder_page_content         - 20
	 */
	do_action( 'finder_page' );
	?>
</div><!-- #post-## -->

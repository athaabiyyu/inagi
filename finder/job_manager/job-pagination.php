<?php
/**
 * Pagination - Show numbered pagination for the `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-pagination.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( $max_num_pages <= 1 ) {
	return;
}

// Calculate pages to output.
$end_size    = 3;
$mid_size    = 3;
$start_pages = range( 1, $end_size );
$end_pages   = range( $max_num_pages - $end_size + 1, $max_num_pages );
$mid_pages   = range( $current_page - $mid_size, $current_page + $mid_size );
$page_links  = array_intersect( range( 1, $max_num_pages ), array_merge( $start_pages, $end_pages, $mid_pages ) );
$prev_page   = 0;
?>
<nav class="job-manager-pagination">
	<ul class="pagination">
		<?php if ( $current_page && $current_page > 1 ) : ?>
			<li class="page-item"><a href="#" class="page-link" data-page="<?php echo esc_attr( $current_page - 1 ); ?>"><i class="fi-chevron-left"></i></a></li>
		<?php endif; ?>

		<?php
		foreach ( $page_links as $page_link ) {
			if ( $prev_page != $page_link - 1 ) {
				echo '<li class="page-item">...</li>';
			}
			if ( $current_page == $page_link ) {
				echo '<li class="page-item active"><span class="page-link" data-page="' . esc_attr( $page_link ) . '">' . esc_html( $page_link ) . '</span></li>';
			} else {
				echo '<li class="page-item"><a href="#" class="page-link"  data-page="' . esc_attr( $page_link ) . '">' . esc_html( $page_link ) . '</a></li>';
			}

			$prev_page = $page_link;
		}
		?>

		<?php if ( $current_page && $current_page < $max_num_pages ) : ?>
			<li class="page-item"><a href="#" class="page-link"  data-page="<?php echo esc_attr( $current_page + 1 ); ?>"><i class="fi-chevron-right"></i></a></li>
		<?php endif; ?>
	</ul>
</nav>

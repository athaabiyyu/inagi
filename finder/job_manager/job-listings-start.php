<?php
/**
 * Content shown before job listings in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-listings-start.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @version     1.15.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$wrapper_classes = 'job_listings';

if ( is_page() && finder_wpjm_get_page_id( 'jobs' ) !== $post->ID ) {
	$wrapper_classes .= ' my-4 m-md-5';
}

?>
<div class="<?php echo esc_attr( $wrapper_classes ); ?>">

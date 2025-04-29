<?php
/**
 * Apply using link to website.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application-url.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @version     1.32.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<p class="pt-2 mb-1"><?php esc_html_e( 'To apply for this job please visit:', 'finder' ); ?></p>
<a class="nav-link-muted fw-bold" href="<?php echo esc_url( $apply->url ); ?>" rel="nofollow"><?php echo esc_html( wp_parse_url( $apply->url, PHP_URL_HOST ) ); ?></a>

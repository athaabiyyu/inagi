<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php finder_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php finder_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php finder_schema_body(); ?> <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div 
<?php
finder_render_attr(
	'site',
	array(
		'id'    => 'page',
		'class' => 'hfeed site page-wrapper',
	)
);
?>
>
	<?php
	finder_header_before();

	finder_header();

	finder_header_after();

	finder_content_before();
	?>
	<div id="content" <?php finder_site_content_class(); ?>>
		<?php finder_content_top(); ?>

<?php
/**
 * Finder Template Hooks.
 *
 * @package Finder
 */

// Load all template hooks files separately.
require_once get_template_directory() . '/inc/template-hooks/header.php';
require_once get_template_directory() . '/inc/template-hooks/single-post.php';
require_once get_template_directory() . '/inc/template-hooks/footer.php';
require_once get_template_directory() . '/inc/template-hooks/loop-post.php';
require_once get_template_directory() . '/inc/template-hooks/page.php';

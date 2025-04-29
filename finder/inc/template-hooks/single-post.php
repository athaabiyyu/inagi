<?php
/**
 * Template hooks used in Single Post.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Single Post Styles.
add_action( 'finder_single_post', 'finder_blog_single_style', 10 );
add_filter( 'the_password_form', 'finder_post_protected_password_form' );

//Sidebar 
add_action( 'finder_before_sidebar', 'finder_search_form', 10 );
add_action( 'finder_before_sidebar', 'finder_single_post_author_sidebar', 20 );

add_action( 'finder_single_post_navigation', 'finder_single_post_navigation', 50 );


// Job Board Demo Hooks.
add_action( 'finder_single_post_job_board_demo', 'finder_breadcrumb', 5 );
add_action( 'finder_single_post_job_board_demo', 'finder_single_post_title', 10 );

add_action( 'finder_single_post_hero_image_job_board', 'finder_single_post_featured_image', 10 );

add_action( 'finder_single_post_body_job_board_demo', 'finder_single_post_meta', 10 );
add_action( 'finder_single_post_body_job_board_demo', 'finder_single_post_excerpt', 20 );
add_action( 'finder_single_post_body_job_board_demo', 'finder_single_post_content', 30 );

add_action( 'finder_single_post_footer_job_board_demo', 'finder_single_post_tag', 10 );
add_action( 'finder_single_post_footer_job_board_demo', 'finder_single_post_share', 20 );

add_action( 'finder_single_post_realted_post_job_board_demo', 'finder_single_post_recent_posts', 10 );

add_action( 'finder_single_post_after_footer_job_board_demo', 'finder_single_post_comment', 10 );

add_action( 'finder_single_post_comment_form_job_board_demo', 'finder_single_post_comment_form', 10 );

// City Guide Demo Hooks.
add_action( 'finder_single_post_city_guide_demo', 'finder_breadcrumb', 5 );
add_action( 'finder_single_post_city_guide_demo', 'finder_single_post_title', 10 );

add_action( 'finder_single_post_hero_image_city_guide_demo', 'finder_single_post_featured_image', 10 );

add_action( 'finder_single_post_body_city_guide_demo', 'finder_single_post_meta', 10 );
add_action( 'finder_single_post_body_city_guide_demo', 'finder_single_post_excerpt', 20 );
add_action( 'finder_single_post_body_city_guide_demo', 'finder_single_post_content', 30 );

add_action( 'finder_single_post_footer_city_guide_demo', 'finder_single_post_tag', 10 );
add_action( 'finder_single_post_footer_city_guide_demo', 'finder_single_post_share', 20 );

add_action( 'finder_single_post_realted_post_city_guide_demo', 'finder_single_post_recent_posts', 10 );

add_action( 'finder_single_post_after_footer_city_guide_demo', 'finder_single_post_comment', 10 );

add_action( 'finder_single_post_comment_form_city_guide_demo', 'finder_single_post_comment_form', 10 );

// Car Finder Demo Hooks.
add_action( 'finder_single_post_car_finder_demo', 'finder_breadcrumb', 5 );
add_action( 'finder_single_post_car_finder_demo', 'finder_single_post_title', 10 );

add_action( 'finder_single_post_hero_image_car_finder', 'finder_single_post_featured_image', 10 );

add_action( 'finder_single_post_body_car_finder_demo', 'finder_single_post_meta', 10 );
add_action( 'finder_single_post_body_car_finder_demo', 'finder_single_post_excerpt', 20 );
add_action( 'finder_single_post_body_car_finder_demo', 'finder_single_post_content', 30 );

add_action( 'finder_single_post_footer_car_finder_demo', 'finder_single_post_tag', 10 );
add_action( 'finder_single_post_footer_car_finder_demo', 'finder_single_post_share', 20 );

add_action( 'finder_single_post_realted_post_car_finder_demo', 'finder_single_post_recent_posts', 10 );

add_action( 'finder_single_post_after_footer_car_finder_demo', 'finder_single_post_comment', 10 );

add_action( 'finder_single_post_comment_form_car_finder_demo', 'finder_single_post_comment_form', 10 );

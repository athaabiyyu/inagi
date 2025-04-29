<?php
/**
 * Template functions used globally across the website.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Schema for <body> tag.
 */
if ( ! function_exists( 'finder_schema_body' ) ) :

	/**
	 * Adds schema tags to the body classes.
	 */
	function finder_schema_body() {

		if ( true !== apply_filters( 'finder_schema_enabled', true ) ) {
			return;
		}

		// Check conditions.
		$is_blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

		// Set up default itemtype.
		$itemtype = 'WebPage';

		// Get itemtype for the blog.
		$itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

		// Get itemtype for search results.
		$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;
		// Get the result.
		$result = apply_filters( 'finder_schema_body_itemtype', $itemtype );

		// Return our HTML.
		echo apply_filters( 'finder_schema_body', "itemtype='https://schema.org/" . esc_attr( $result ) . "' itemscope='itemscope'" ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

/**
 * Finder Pagination
 */
if ( ! function_exists( 'finder_number_pagination' ) ) {

	/**
	 * Finder Pagination
	 *
	 * @since 1.0.0
	 * @return void            Generate & echo pagination markup.
	 */
	function finder_number_pagination() {
		global $wp_query;
		$enabled = apply_filters( 'finder_pagination_enabled', true );

		// Don't print empty markup if their is only one page.
		if ( $wp_query->max_num_pages < 2 || ! $enabled ) {
			return;
		}

			ob_start();
			echo "<div class='ast-pagination'>";
			the_posts_pagination(
				array(
					'prev_text'    => finder_default_strings( 'string-blog-navigation-previous', false ),
					'next_text'    => finder_default_strings( 'string-blog-navigation-next', false ),
					'taxonomy'     => 'category',
					'in_same_term' => true,
				)
			);
			echo '</div>';
			$output = ob_get_clean();
			echo apply_filters( 'finder_pagination_markup', $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

add_action( 'finder_pagination', 'finder_number_pagination' );

/**
 * Return or echo site logo markup.
 *
 * @since 2.2.0
 * @param boolean $display_site_title Site title enable or not.
 * @param boolean $display_site_tagline Site tagline enable or not.
 *
 * @return string return markup.
 */
function finder_get_site_title_tagline( $display_site_title, $display_site_tagline ) {
	$html = '';

	if ( ! apply_filters( 'finder_disable_site_identity', false ) ) {

		// Site Title.
		$tag = 'span';
		if ( is_home() || is_front_page() ) {
			$tag = 'h1';
		}

		/**
		 * Filters the site title output.
		 *
		 * @since 1.4.9
		 *
		 * @param string the HTML output for Site Title.
		 */
		// Site Title.
		$site_title_markup = apply_filters(
			'finder_site_title_output',
			sprintf(
				'<%1$s %4$s>
				<a href="%2$s" rel="home" %5$s >
					%3$s
				</a>
			</%1$s>',
				/**
				* Filters the tags for site title.
				*
				* @since 1.3.1
				*
				* @param string $tags string containing the HTML tags for Site Title.
				*/
				apply_filters( 'finder_site_title_tag', $tag ),
				/**
				* Filters the href for the site title.
				*
				* @since 1.4.9
				*
				* @param string site title home url
				*/
				esc_url( apply_filters( 'finder_site_title_href', home_url( '/' ) ) ),
				/**
				* Filters the site title.
				*
				* @since 1.4.9
				*
				* @param string site title
				*/
				apply_filters( 'finder_site_title', get_bloginfo( 'name' ) ),
				finder_attr(
					'site-title',
					array(
						'class' => 'site-title',
					)
				),
				finder_attr(
					'site-title-link',
					array()
				)
			)
		);

		// Site Description.
		/**
		 * Filters the site description markup.
		 *
		 * @since 1.4.9
		 *
		 * @param string the HTML output for Site Title.
		 */
		$site_tagline_markup = apply_filters(
			'finder_site_description_markup',
			sprintf(
				'<%1$s class="site-description" itemprop="description">
				%2$s
			</%1$s>',
				/**
				* Filters the tags for site tagline.
				*
				* @since 1.8.5
				*/
				apply_filters( 'finder_site_tagline_tag', 'p' ),
				/**
				* Filters the site description.
				*
				* @since 1.4.9
				*
				* @param string site description
				*/
				apply_filters( 'finder_site_description', get_bloginfo( 'description' ) )
			)
		);

		if ( $display_site_title || $display_site_tagline ) {
			/* translators: 1: Site Title Markup, 2: Site Tagline Markup */
			$html .= sprintf(
				'<div class="ast-site-title-wrap">
						%1$s
						%2$s
				</div>',
				( $display_site_title ) ? $site_title_markup : '',
				( $display_site_tagline ) ? $site_tagline_markup : ''
			);
		}
	}
	return $html;
}

if ( ! function_exists( 'finder_breadcrumb' ) ) {

	/**
	 * Output the Finder Breadcrumb.
	 *
	 * @param array $args Arguments.
	 */
	function finder_breadcrumb( $args = array() ) {
		$bc_class = 'breadcrumb';
		if ( isset( $args['style'] ) ) {
			if ( 'dark' === $args['style'] ) {
				$bc_class .= ' breadcrumb-dark';
			} elseif ( 'light' === $args['style'] ) {
				$bc_class .= ' breadcrumb-light';
			}
		}

		if ( finder_is_dark_background() ) {
			$bc_class .= ' breadcrumb-light';
		}

		$nav_class = 'mb-3 pt-md-3';
		if ( isset( $args['nav_class'] ) && $args['nav_class'] ) {
			$nav_class = $args['nav_class'];
		}

		$wrap_before = '<nav class="' . esc_attr( $nav_class ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'finder' ) . '"><ol class="' . esc_attr( $bc_class ) . '">';

		if ( isset( $args['align'] ) && 'left' === $args['align'] ) {
			$wrap_before = '<nav class="finder-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'finder' ) . '"><ol class="' . esc_attr( $bc_class ) . '">';
		}

		$args = wp_parse_args(
			$args,
			apply_filters(
				'finder_breadcrumb_defaults',
				array(
					'delimiter'   => '',
					'wrap_before' => $wrap_before,
					'wrap_after'  => '</ol></nav>',
					'before'      => '<li class="breadcrumb-item">',
					'after'       => '</li>',
					'home'        => _x( 'Home', 'breadcrumb', 'finder' ),
				)
			)
		);

		require_once get_template_directory() . '/inc/classes/class-finder-breadcrumb.php';
		$breadcrumbs = new Finder_Breadcrumb();

		if ( ! empty( $args['home'] ) ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'finder_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		/**
		 * Finder Breadcrumb hook
		 *
		 * @hooked finder_Structured_Data::generate_breadcrumblist_data() - 10
		 */
		do_action( 'finder_breadcrumb', $breadcrumbs, $args );

		finder_get_template( 'global/breadcrumb.php', $args );
	}
}

if ( ! function_exists( 'finder_page_title' ) ) {
	/**
	 * Displays the page title.
	 */
	function finder_page_title() {

		$page_title       = '';
		$page_title_class = '';

		if ( ! ( is_front_page() && is_home() ) ) {
			if ( is_front_page() ) {
				// Static homepage.
				$page_title_class = get_the_title();
				$page_title       = 'my-4';
			} elseif ( is_home() ) {
				// Blog page.
				$page_title       = get_the_title( get_option( 'page_for_posts', false ) );
				$page_title_class = 'mb-4';
			} elseif ( is_archive() ) {
				$page_title       = get_the_archive_title();
				$page_title_class = 'mb-4';
			} elseif ( is_single() ) {
				$page_title       = get_the_title();
				$page_title_class = 'h2 pb-3';
			} elseif ( is_front_page() && ! is_home() ) {
				$page_title       = get_the_title();
				$page_title_class = 'mb-0';
			} 
			elseif( is_search() ) {
				$page_title       = sprintf( esc_html__( 'Search Results for "%s"', 'finder' ), get_search_query() );;
				$page_title_class = 'mb-4';
			}else {
				$page_title_class = 'mb-4';
				$page_title       = get_the_title();
			}
		}

		if ( finder_is_dark_background() ) {
			$page_title_class .= ' text-light';
		}

		$style = finder_get_blog_style();

		if ( 'car-finder' === $style ) {
			$page_title_class .= ' pt-1';
		}

		if ( 'job-board' === $style ) {
			$page_title_class = 'mb-[0.75rem] pt-2';
		}

		if ( 'city-guide' === $style ) {
			$page_title_class = 'mb-1';
		}

		$page_title = apply_filters( 'finder_page_title', $page_title );

		if ( ! empty( $page_title ) ) {
			echo '<h1 class="' . esc_attr( $page_title_class ) . '">' . wp_kses_post( $page_title ) . '</h1>';
		}
	}
}

if ( ! function_exists( 'finder_link_pages' ) ) {
	/**
	 * Output page links.
	 */
	function finder_link_pages() {
		$link_pages = wp_link_pages(
			array(
				'before'      => '<div class="page-links mb-0"><span class="d-block text-dark mb-2">' . esc_html__( 'Pages:', 'finder' ) . '</span><nav class="pagination mb-0">',
				'after'       => '</nav></div>',
				'link_before' => '<span class="page-link is-active">',
				'link_after'  => '</span>',
				'echo'        => 0,
			)
		);
		$link_pages = str_replace( 'post-page-numbers', 'page-item d-sm-block text-decoration-none', $link_pages );
		$link_pages = str_replace( 'current', 'active', $link_pages );
		$link_pages = str_replace( 'is-active', 'current', $link_pages );

		echo wp_kses_post( $link_pages );
	}
}

if ( ! function_exists( 'finder_get_post_breadcrumb' ) ) {
	/**
	 * Output page links.
	 *
	 * @param array $crumbs The crumbs array.
	 * @param obj   $obj    The object.
	 * @return array
	 */
	function finder_get_post_breadcrumb( $crumbs, $obj ) {
		if ( is_home() ) {
			if ( isset( $crumbs[2] ) && get_query_var( 'paged' ) < 2 ) {
				unset( $crumbs[2] );
			}

			if ( empty( $crumbs[1][0] ) ) {
				$crumbs[1][0] = esc_html__( 'Blog', 'finder' );
			}
		}
		return $crumbs;
	}
}


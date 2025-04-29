<?php
/**
 * Template functions related to loop posts.
 *
 * @package Finder/TemplateFunctions/LoopPosts
 */

if ( ! function_exists( 'finder_loop_post_category' ) ) {
	/**
	 * Display loop post category.
	 *
	 * @param string $cat_link_class Class for the category list.
	 * @param string $view view template for the category list.
	 */
	function finder_loop_post_category( $cat_link_class = '', $view = '' ) {

		$get_cat_link_classes = trim( 'text-uppercase text-decoration-none ' . $cat_link_class );
		if ( 'single-post-default' === $view ) {
			$get_cat_link_classes = trim( 'text-decoration-none ' . $cat_link_class );
		}
		$find                 = 'rel="category';
		$replace              = 'class="' . esc_attr( $get_cat_link_classes ) . '" rel="category';
		$categories_list      = get_the_category_list( esc_html__( ', ', 'finder' ) );
		$categories_list      = str_replace( $find, $replace, $categories_list );

		echo wp_kses_post( $categories_list );
	}
}

if ( ! function_exists( 'finder_loop_post_pagination' ) ) {
	/**
	 * Display Blog Post Pagination.
	 *
	 * @param string $style Option. The style of the pagination.
	 */
	function finder_loop_post_pagination( $style = '' ) {
		$blog_style = empty( $style ) ? finder_get_blog_style() : $style;
		$nav_class  = 'pt-4 border-top';
		$ul_class   = 'mb-0';

		switch ( $blog_style ) {
			case 'real-estate':
			case 'job-board':
				$nav_class = 'pt-4 border-top pb-2 mb-5';
				$ul_class  = 'mb-0';
				break;
			case 'car-finder':
				$nav_class = 'pt-4 border-top border-light mb-5';
				$ul_class  = 'pagination-light';
				break;
			case 'city-guide':
				$ul_class  = 'mb-0';
				$nav_class = 'd-flex justify-content-end pt-4 border-top mb-5';
				break;
		}

		finder_bootstrap_pagination( null, true, $nav_class, $ul_class );
	}
}

if ( ! function_exists( 'finder_the_post_meta' ) ) {
	/**
	 * Displays the post meta information.
	 *
	 * @param string $meta   The meta information.
	 * @param string $view   The blog post view.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_meta( $meta, $view = 'default', $before = '', $after = '' ) {
		switch ( $meta ) {
			case 'categories':
				finder_the_post_categories( $view, $before, $after );
				break;
			case 'date':
				finder_the_post_date( $view, $before, $after );
				break;
			case 'comments':
				finder_the_post_comments( $view, $before, $after );
				break;
			case 'read':
				finder_the_post_read( $view, $before, $after );
				break;
			case 'author':
				finder_the_post_author( $view, $before, $after );
				break;
		}
	}
}

if ( ! function_exists( 'finder_the_post_author' ) ) {
	/**
	 * Displays the post author.
	 *
	 * @param string $view The blog post view.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_author( $view = 'default', $before = '', $after = '' ) {

		$profile_url  = get_author_posts_url( get_the_author_meta( 'ID' ) );
		$display_name = get_the_author();

		echo wp_kses_post( $before );
		?>
		<a href="<?php echo esc_url( $profile_url ); ?>" class="text-reset text-decoration-none"><i class="fi-user opacity-70 me-2"></i><?php echo esc_html( $display_name ); ?></a>
		<?php
		echo wp_kses_post( $after );
	}
}

if ( ! function_exists( 'finder_the_post_categories' ) ) {
	/**
	 * Displays the post categories.
	 *
	 * @param string $view The blog post view.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_categories( $view = 'default', $before = '', $after = '' ) {

		$link_class = '';
		$wrap_class = 'mb-2';

		if ( 'single-post-real-estate' === $view ) {
			$link_class = 'nav-link d-inline-block fw-normal px-0';
		}
		if ( 'single-post-default' === $view ) {
			$wrap_class .= ' text-primary';
		}

		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>"><?php finder_loop_post_category( $link_class, $view ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'finder_the_post_read' ) ) {
	/**
	 * Displays the post read time.
	 *
	 * @param string $view The blog post view.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_read( $view = 'default', $before = '', $after = '' ) {
		$args = array();

		if ( 'single-post-real-estate' === $view ) {
			$args = array(
				'i' => 'fi-clock me-2 mt-n1 opacity-60',
			);
		}

		$read_string = finder_get_the_post_read( $args );

		$output_read_string = finder_get_post_meta_html( $read_string, $args );
		$allowed_html       = finder_get_post_meta_allowed_html();

		if ( ! empty( $output_read_string ) && ! empty( $before ) ) {
			echo wp_kses_post( $before );
		}

		echo wp_kses( $output_read_string, $allowed_html );

		if ( ! empty( $output_read_string ) && ! empty( $after ) ) {
			echo wp_kses_post( $after );
		}
	}
}

if ( ! function_exists( 'finder_get_the_post_read' ) ) {
	/**
	 * Get the post read time.
	 *
	 * @param string $args Arguments for the post read HTML.
	 */
	function finder_get_the_post_read( $args = array() ) {
		$defaults = array(
			'wrap'       => false,
			'wrap_class' => false,
			'i'          => 'fi-clock opacity-70 me-2',
		);

		$args = wp_parse_args( $args, $defaults );

		return finder_single_post_reading_time( false );
	}
}

if ( ! function_exists( 'finder_the_post_date' ) ) {
	/**
	 * Displays the post date.
	 *
	 * @param string $view   The blog post view.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_date( $view = 'default', $before = '', $after = '' ) {
		$args = array();
		switch ( $view ) {
			case 'single-post-default':
				$args = array(
					'wrap'       => 'a',
					'wrap_class' => 'text-reset text-decoration-none',
					'i'          => 'fi-calendar-alt opacity-70 me-2',
				);
				break;
			case 'single-post-real-estate':
				$args = array(
					'wrap' => false,
					'i'    => 'fi-calendar-alt me-2 mt-n1 opacity-60',
				);
				break;
		}
		$output_time_string = finder_get_the_post_date( $args );

		$allowed_html = finder_get_post_meta_allowed_html();

		if ( ! empty( $output_time_string ) && ! empty( $before ) ) {
			echo wp_kses_post( $before );
		}

		echo wp_kses( $output_time_string, $allowed_html );

		if ( ! empty( $output_time_string ) && ! empty( $after ) ) {
			echo wp_kses_post( $after );
		}
	}
}

if ( ! function_exists( 'finder_get_the_post_date' ) ) {
	/**
	 * Get the post date HTML.
	 *
	 * @param string $args Arguments for generating the HTML.
	 */
	function finder_get_the_post_date( $args = array() ) {
		$defaults = array(
			'wrap'       => 'span',
			'wrap_class' => 'me-2 pe-1',
			'i'          => 'fi-calendar-alt opacity-70 mt-n1 me-1 align-middle',
		);

		$args = wp_parse_args( $args, $defaults );

		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published d-none" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		if ( 'a' === $args['wrap'] ) {
			$args['wrap_attr'] = array(
				'href' => get_permalink(),
				'rel'  => 'bookmark',
			);
		}

		$output_time_string = finder_get_post_meta_html( $time_string, $args );

		return $output_time_string;
	}
}

if ( ! function_exists( 'finder_the_post_comments' ) ) {
	/**
	 * Displays the post comments meta data.
	 *
	 * @param string $view View of the loop or single post.
	 * @param string $before Output before string.
	 * @param string $after  Output after string.
	 */
	function finder_the_post_comments( $view = 'default', $before = '', $after = '' ) {

		switch ( $view ) {
			case 'single-post-default':
				$args = array(
					'i'          => 'fi-chat-circle opacity-70 me-2',
					'wrap'       => 'a',
					'wrap_class' => 'nav-link-muted d-flex align-items-center',
				);
				break;
			case 'single-post-real-estate':
				$args = array(
					'i'    => 'fi-chat-circle me-2 mt-n1 opacity-60',
					'wrap' => false,
				);
				break;
			default:
				$args = array();
		}

		$comments = finder_get_the_post_comments( $args );

		$allowed_html = finder_get_post_meta_allowed_html();

		if ( ! empty( $comments ) && ! empty( $before ) ) {
			echo wp_kses_post( $before );
		}

		echo wp_kses( $comments, $allowed_html );

		if ( ! empty( $comments ) && ! empty( $after ) ) {
			echo wp_kses_post( $after );
		}
	}
}

if ( ! function_exists( 'finder_get_the_post_comments' ) ) {
	/**
	 * Get the post comments HTML.
	 *
	 * @param string $args Arguments for generating the post comments HTML.
	 */
	function finder_get_the_post_comments( $args = array() ) {
		$comments = '';
		$defaults = array(
			'i'          => 'fi-chat-circle opacity-70 mt-n1 me-1 align-middle',
			'wrap'       => 'span',
			'wrap_class' => 'post-comments',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$comments_number = get_comments_number_text( esc_html__( 'Leave a comment', 'finder' ), esc_html__( '1 Comment', 'finder' ), esc_html__( '% Comments', 'finder' ) );

			if ( 'a' === $args['wrap'] ) {
				$args['wrap_attr'] = array(
					'href' => get_comments_link(),
				);
			}

			$comments = finder_get_post_meta_html( $comments_number, $args );
		}

		return $comments;
	}
}

if ( ! function_exists( 'finder_get_post_meta_html' ) ) {
	/**
	 * Get the post meta HTML.
	 *
	 * @param string $content The content of the post meta.
	 * @param array  $args    The arguments for generating the HTML.
	 * @return string
	 */
	function finder_get_post_meta_html( $content, $args = array() ) {
		$html = '';

		$icon = '';
		if ( ! empty( $args['i'] ) ) {
			$icon = '<i class="' . esc_attr( $args['i'] ) . '"></i>';
		}

		$html = $icon . $content;

		if ( ! isset( $args['wrap_attr'] ) ) {
			$args['wrap_attr'] = array();
		}

		if ( ! empty( $args['wrap_class'] ) ) {
			$args['wrap_attr']['class'] = $args['wrap_class'];
		}

		if ( ! empty( $args['wrap'] ) && ! empty( $args['wrap_attr'] ) ) {
			$wrap_attr_string = finder_render_attr( 'post-meta', $args['wrap_attr'], $args, false );
		}

		if ( ! empty( $args['wrap'] ) ) {
			$html = '<' . $args['wrap'] . ' ' . $wrap_attr_string . '>' . $html . '</' . $args['wrap'] . '>';
		}

		return $html;
	}
}

if ( ! function_exists( 'finder_blog_sidebar' ) ) {
	/**
	 * Displays Blog Sidebar
	 */
	function finder_blog_sidebar() {
		$has_sidebar     = finder_has_blog_sidebar();
		$style           = finder_get_blog_style();
		$sidebar_classes = 'blog-sidebar-widgets widget-area';

		if ( 'job-board' === $style ) {
			$sidebar_classes .= ' col-lg-4';
		} else {
			$sidebar_classes .= ' col-lg-3';
		}

		if ( 'city-guide' === $style || 'real-estate' === $style || 'car-finder' === $style || 'default' === $style ) {
			$has_sidebar = false; // This is because we will be loading the sidebar inside the loop.
		}

		if ( $has_sidebar && is_active_sidebar( 'sidebar-blog' ) ) :
			?>
			<aside id="secondary" class="<?php echo esc_attr( $sidebar_classes ); ?>" role="complementary">
				<div class="offcanvas offcanvas-end offcanvas-collapse" id="blog-sidebar">
	              	<div class="offcanvas-header shadow-sm mb-2">
	                	<h2 class="h5 mb-0"><?php echo esc_html__( 'Sidebar', 'finder' ); ?></h2>
	                	<button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
	              	</div>
              		<div class="offcanvas-body">
						<?php dynamic_sidebar( 'sidebar-blog' ); ?>
					</div>
				</div>
			</aside>
			<?php finder_sidebar_button(); ?>
			<?php
		endif;
	}
}

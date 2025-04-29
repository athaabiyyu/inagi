<?php
/**
 * Template functions related to Single Post.
 *
 * @package Finder/TemplateFunctions/SinglePost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'finder_blog_single_style' ) ) {
	/**
	 * Display single post content.
	 */
	function finder_blog_single_style() {
		$blog_single_style = finder_get_blog_single_style();
		finder_get_template( 'single-post/single-post-' . $blog_single_style . '.php' );
	}
}


if ( ! function_exists( 'finder_single_post_category_link_class' ) ) {
	/**
	 * Display single post category link class.
	 *
	 * @param  string $style      The style of the single post.
	 * @return string $link_class
	 */
	function finder_single_post_category_link_class( $style = 'real-estate' ) {
		$style = empty( $style ) ? finder_get_blog_single_style() : $style;

		$link_class = 'd-inline-block fw-normal text-uppercase px-0';

		switch ( $style ) {
			case 'real-estate':
				$link_class = 'nav-link d-inline-block fw-normal text-uppercase px-0';
				break;
			case 'job-board':
			case 'city-guide':
				$link_class = 'text-uppercase text-decoration-none';
				break;
			case 'car-finder':
				$link_class = 'text-uppercase text-decoration-none';
				break;
		}

		return $link_class;
	}
}

if ( ! function_exists( 'finder_single_post_category' ) ) {
	/**
	 * Display single post category.
	 *
	 * @param string $style Optional. The style of the single post.
	 */
	function finder_single_post_category( $style = '' ) {
		$link_class   = finder_single_post_category_link_class( $style );
		$single_style = finder_get_blog_single_style();
		$wrap_class   = '';
		if ( 'car-finder' === $style ) {
			$wrap_class = 'border-end border-light pe-3 me-3';
		} elseif ( 'job-board' === $single_style || 'city-guide' === $single_style ) {
			$wrap_class = 'border-end pe-3 me-3';
		}
		$find            = 'rel="category';
		$replace         = 'class="' . esc_attr( $link_class ) . '" rel="category';
		$categories_list = get_the_category_list( esc_html__( ', ', 'finder' ) );
		$categories_list = str_replace( $find, $replace, $categories_list );
		?><div class="<?php echo esc_attr( $wrap_class ); ?>"><?php echo wp_kses_post( $categories_list ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'finder_single_post_title' ) ) {
	/**
	 * Display single post title.
	 */
	function finder_single_post_title() {
		$style = finder_get_blog_single_style();

		$before = '<h1 class="h2 mb-4">';
		$after  = '</h1>';

		switch ( $style ) {
			case 'real-estate':
				$before = '<h1 class="h2 mb-4">';
				break;
			case 'job-board':
			case 'city-guide':
				$before = '<h1 class="h2 pb-3">';
				break;
			case 'car-finder':
				$before = '<h1 class="h2 text-light pb-3">';
				break;
		}

		the_title( $before, $after );
	}
}

// Single post real-estae-demo meta.
if ( ! function_exists( 'finder_single_post_real_estate_demo_meta' ) ) {
	/**
	 * Display real-estae-demo meta.
	 */
	function finder_single_post_real_estate_demo_meta() {
		?>
		<div class="mb-4 pb-1">
			<ul class="list-unstyled d-flex flex-wrap mb-0 text-nowrap">
				<li class="me-3"><?php finder_single_post_date(); ?></li>
				<li class="me-3 border-end"></li>
				<li class="me-3"><i class="fi-clock me-2 mt-n1 opacity-60"></i><?php finder_single_post_reading_time(); ?></li>
				<li class="me-3 border-end"></li>
				<li class="me-3"><a class="nav-link-muted" href="#comments" data-scroll=""><i class="fi-chat-circle me-2 mt-n1 opacity-60"></i><?php finder_single_post_comments_count(); ?></a></li>
			</ul>
		</div>
		<?php
	}
}

// Single post meta.
if ( ! function_exists( 'finder_single_post_meta' ) ) {
	/**
	 * Display single post meta.
	 */
	function finder_single_post_meta() {
		$style               = finder_get_blog_single_style();
		$wrapper_class       = ( ( 'car-finder' === $style ) && ( 'real-estate' !== $style ) ) ? ' border-light' : '';
		$reading_time_class  = ( ( 'car-finder' === $style ) && ( 'real-estate' !== $style ) ) ? ' text-light border-light' : '';
		$comment_count_class = ( ( 'car-finder' === $style ) && ( 'real-estate' !== $style ) ) ? ' text-light text-decoration-none' : ' nav-link-muted';
		?>
		<div class="d-flex flex-wrap border-bottom pb-3 mb-4 <?php echo esc_attr( $wrapper_class ); ?>">
			<?php finder_single_post_category(); ?>
			<?php finder_single_post_date(); ?>
			<div class="d-flex align-items-center border-end pe-3 me-3 mb-2 <?php echo esc_attr( $reading_time_class ); ?>">
				<i class="fi-clock opacity-70 me-2"></i><span><?php finder_single_post_reading_time(); ?></span>
			</div>
			<a class="d-flex align-items-center mb-2 <?php echo esc_attr( $comment_count_class ); ?>" href="#comments" data-scroll="">
				<i class="fi-chat-circle opacity-70 me-2"></i><span><?php finder_single_post_comments_count(); ?></span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_single_post_reading_time' ) ) {
	/**
	 * Display single post reading_time.
	 *
	 * @param bool $echo Should echo or return.
	 * @return void|string
	 */
	function finder_single_post_reading_time( $echo = true ) {
		$post_content = get_post_field( 'post_content' );
		$minutes      = finder_get_read_time( $post_content );
		if ( 1 <= $minutes ) :
			$reading_time = sprintf(
				/* translators: 1: number of minutes, 2: minutes to read */
				_nx( '%1$s min read', '%1$s mins read', $minutes, 'minutes to read', 'finder' ),
				$minutes
			);
		else :
			$reading_time = esc_html__( 'Less than a minute to read', 'finder' );
		endif;

		if ( $echo ) {
			echo esc_html( $reading_time );
		} else {
			return $reading_time;
		}
	}
}

if ( ! function_exists( 'finder_single_post_author' ) ) {
	/**
	 * Display single post author.
	 */
	function finder_single_post_author() {
		?>
		
		<div class="mb-4 pb-md-3">
			<a class="d-flex align-items-center text-body text-decoration-none" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'rounded-circle' ) ); ?>
				<div class="ps-3">
					<h2 class="h6 mb-1"><?php echo esc_html( get_the_author() ); ?></h2>
					<?php if ( ! empty( get_the_author_meta( 'user_description' ) ) ) : ?>
						<div class="fs-sm"><?php the_author_meta( 'user_description' ); ?></div>
					<?php endif; ?>
				</div>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_single_post_tags' ) ) {
	/**
	 * Display single post tag.
	 *
	 * @param string $style The single post style.
	 */
	function finder_single_post_tags( $style = 'real-estate' ) {
		$tags_list = get_the_tag_list( '' );
		$find      = 'rel="tag"';
		$replace   = 'class="btn btn-xs btn-outline-secondary rounded-pill fs-sm fw-normal me-2 mb-2" rel="tag"';

		$wrap_class  = 'd-flex align-items-center me-3 mb-3 mb-md-0';
		$label_class = 'd-none d-sm-block fw-bold text-nowrap mb-2 me-2 pe-1';

		if ( 'real-estate' === $style ) {
			$wrap_class  = 'd-flex align-items-center mb-5 mb-md-5 pb-3 pb-md-4';
			$label_class = 'fw-bold text-nowrap mb-2 me-2 pe-1';
		}
		if ( ! empty( $tags_list ) ) {
			?>
			<div class="<?php echo esc_attr( $wrap_class ); ?>">
				<div class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html__( 'Tags:', 'finder' ); ?></div>
				<div class="d-flex flex-wrap"><?php echo wp_kses_post( str_replace( $find, $replace, $tags_list ) ); ?></div>
			</div>
			<?php
		}
	}
}

// Single post share.
if ( ! function_exists( 'finder_single_post_share' ) ) {
	/**
	 * Display single post share.
	 *
	 * @param string $style Optional. Style of the single post.
	 */
	function finder_single_post_share( $style = '' ) {
		if ( ! finder_single_post_is_share_enabled() ) {
			return;
		}

		$style    = empty( $style ) ? finder_get_blog_single_style() : $style;
		$services = Finder_SocialShare::get_share_services();

		if ( ! $services ) {
			return;
		}

		$btn_class   = 'btn btn-icon btn-xs rounded-circle';
		$label_class = '';
		$has_wrap    = false;
		$is_vertical = false;
		$flex_class  = 'd-flex align-items-center';

		switch ( $style ) {
			case 'car-finder':
				$btn_class  .= ' btn-translucent-light mb-2 ms-2';
				$label_class = 'fw-bold text-nowrap pe-1 mb-2 text-light';
				break;
			case 'city-guide':
				$btn_class  .= ' btn-light-primary shadow-sm mb-2 ms-2';
				$label_class = 'fw-bold text-nowrap pe-1 mb-2';
				break;
			case 'job-board':
				$btn_class  .= ' btn-light-primary shadow-sm mb-2 ms-2';
				$label_class = 'fw-bold text-nowrap pe-1 mb-2';
				break;
			case 'real-estate':
				$btn_class  .= ' btn-light-primary shadow-sm mb-2 ms-2';
				$label_class = 'd-md-none fw-bold text-nowrap me-2 pe-1';
				$has_wrap    = true;
				$is_vertical = true;
				$flex_class  = 'd-flex flex-md-column align-items-center my-2 mt-md-4 pt-md-5';
				break;
			default:
				$btn_class  .= ' btn-light-primary shadow-sm mb-2 ms-2';
				$label_class = 'fw-bold text-nowrap pe-1 mb-2';
		}

		if ( $has_wrap ) {
			echo '<div class="sticky-top py-md-5 mt-md-5">';
		}

		?>
		<div class="<?php echo esc_attr( $flex_class ); ?>">
			<div class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html__( 'Share :', 'finder' ); ?></div>
			<?php if ( ! $is_vertical ) : ?>
			<div class="d-flex">
			<?php endif; ?>
				<?php
				foreach ( $services as $service ) :
					if ( ! isset( $service['share'] ) ) {
						continue;
					}
					/* translators: %s - name of the social sharing service */
					$btn_title = sprintf( esc_html__( 'Share in %s', 'finder' ), $service['name'] );
					?>
					<a href="<?php echo esc_url( $service['share'] ); ?>" class="<?php echo esc_attr( $btn_class ); ?>" target="_blank" rel="noopener noreferrer" data-bs-toggle="tooltip" title="<?php echo esc_html( $btn_title ); ?>">
						<?php if ( isset( $service['icon'] ) ) : ?>
							<i class="<?php echo esc_attr( $service['icon'] ); ?>"></i>
						<?php endif; ?>
					</a>
					<?php
				endforeach;
				?>
			<?php if ( ! $is_vertical ) : ?>
			</div>
			<?php endif; ?>
		</div>
		<?php

		if ( $has_wrap ) {
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'finder_single_post_comment' ) ) {
	/**
	 * Display Comments for single post.
	 */
	function finder_single_post_comment() {
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}

if ( ! function_exists( 'finder_comment' ) ) {
	/**
	 * Finder comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0.0
	 */
	function finder_comment( $comment, $args, $depth ) {
		global $post;

		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment-reply-target';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		$style = finder_get_blog_single_style();

		$comment_class = array();

		if ( empty( $args['has_children'] ) ) {
			$comment_class[] = 'parent';
		}

		static $count  = 1;
		$comment_count = (int) get_comments_number();

		if ( 1 === $depth ) {
			$comment_class[] = ( 'car-finder' === $style ) ? 'border-bottom border-light pb-4 mb-4' : 'pb-4';

			if ( $count !== $comment_count && 'car-finder' !== $style ) {
				$comment_class[] = 'border-bottom mb-4';
			}
		}

		if ( $depth > 1 ) {
			$comment_class[] = ( 'car-finder' === $style ) ? 'border-start border-left-4 border-light ps-4 ms-4 mt-4' : 'border-start border-left-4 ps-4 ms-4 mt-4';
		}

		$comment_class = implode( ' ', $comment_class );

		?>

		<<?php echo esc_attr( $tag ); ?> <?php comment_class( $comment_class ); ?> id="comment-<?php comment_ID(); ?>">
		<?php
		$comment_desc_class   = ( 'car-finder' === $style ) ? 'text-light opacity-70' : '';
		$comment_author_class = ( 'car-finder' === $style ) ? 'text-light' : '';
		$comment_date_class   = ( 'car-finder' === $style ) ? 'text-light opacity-50' : 'text-muted';
		$reply_button_class   = ( 'car-finder' === $style ) ? 'btn-light' : '';
		?>
		<div class="comment__body <?php echo esc_attr( $comment_desc_class ); ?>">
			<div class="prose mb-4"><?php comment_text(); ?></div>
		</div>
		<div class="d-flex justify-content-between align-items-center">
			<div class="d-flex align-items-center pe-2 space-x-2">
				<?php echo get_avatar( $comment, 48, '', esc_html__( 'author', 'finder' ), array( 'class' => 'rounded-circle me-1' ) ); ?>
				<div>
					<h6 class="fs-base mb-0 <?php echo esc_attr( $comment_author_class ); ?>"><?php echo esc_html( get_comment_author( $comment ) ); ?>
						<?php if ( $comment->user_id === $post->post_author ) : ?>
							<span class="badge bg-info rounded-pill fs-xs ms-2"><?php echo esc_html__( 'Author', 'finder' ); ?></span>
						<?php endif; ?>
					</h6>
					<span class="fs-sm <?php echo esc_attr( $comment_date_class ); ?>"><?php echo esc_html( get_comment_date() ); ?></span>
				</div>
			</div>
			<div>
				<?php
					$reply_link = str_replace(
						"'>",
						"'><i class='fi-reply fs-lg me-2'></i>",
						get_comment_reply_link(
							array_merge(
								$args,
								array(
									'add_below' => $add_below,
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
								)
							),
							$comment
						)
					);

					$reply_link = str_replace(
						'comment-reply-link',
						'comment-reply-link text-muted text-decoration-none btn btn-link btn-sm fw-normal',
						$reply_link
					);

					echo wp_kses_post( $reply_link );

				if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) :
					?>
						<a class="comment-edit-link text-muted text-decoration-none" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>"><?php esc_html_e( 'Edit', 'finder' ); ?></a>
						<?php
					endif;
				?>
			</div>
		</div>
		<div id="comment-reply-target-<?php comment_ID(); ?>" class="comment-reply-target"></div>

		<?php if ( 'div' !== $args['style'] ) : ?>
		</div>
			<?php
		endif;

		$count++;
	}
}

// Single post comment form.
if ( ! function_exists( 'finder_single_post_comment_form' ) ) {
	/**
	 * Display single post comment form.
	 */
	function finder_single_post_comment_form() {

		if ( ! comments_open() || post_password_required() ) {
			return;
		}

		$style = finder_get_blog_single_style();

		$title_class = ( 'car-finder' === $style ) ? ' text-light' : '';
		$label_class = ( 'car-finder' === $style ) ? ' text-light' : '';
		$input_class = ( 'car-finder' === $style ) ? ' form-control-light' : '';

		$args = array(
			'class_container'      => 'comment-respond',
			'fields'               => array(
				// Author field.
				'author'  => '<div class="col-sm-6"><label for="author" class="form-label' . $label_class . '">' . esc_html__( 'Name', 'finder' ) . '<span class="text-danger">*</span></label><input type="text" aria-label="' . esc_attr__( 'First name', 'finder' ) . '" input id="author" name="author" aria-required="true" placeholder="' . esc_attr__( 'Name', 'finder' ) . '" class="form-control form-control-lg' . $input_class . '"></input></div>',
				// Email Field.
				'email'   => '<div class="col-sm-6"><label for="email" class="form-label' . $label_class . '">' . esc_html__( 'Email', 'finder' ) . '<span class="text-danger">*</span></label><input type="email" input id="email" name="email" placeholder="' . esc_attr__( 'Email', 'finder' ) . '" class="form-control form-control-lg' . $input_class . '"></input></div>',
				// Cookies.
				'cookies' => '<div class="col-md-12"><div class="form-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"><label for="flexCheckDefault" class="form-check-label' . $label_class . '">' . esc_html__( 'Save my name and email in this browser for the next time I comment.', 'finder' ) . '</label></div></div>',
				// URL Field.

				'url'     => '<div class="col-12"><label for="url" class="form-label' . $label_class . '">' . esc_html__( 'Website', 'finder' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'https://', 'finder' ) . '" class="form-control form-control-lg' . $input_class . '"></input></div>',
			),
			'class_form'           => 'needs-validation row gy-md-4 gy-3 pb-sm-2',
			'title_reply'          => esc_html__( 'Leave your comment', 'finder' ),
			'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title mb-3 pb-sm-2' . $title_class . '">',
			'title_reply_after'    => '</h3>',
			'comment_field'        => '<div class="col-12 mt-0"><label for="comment" class="form-label comment-form-comment' . $label_class . '">' . esc_html__( 'Your Comment', 'finder' ) . '<span class="text-danger">*</span></label><textarea id="comment" name="comment" aria-required="true" class="form-control form-control-lg' . $input_class . '" rows="4"></textarea></div>',
			'submit_button'        => '<div class="col-12 py-2 pt-2"><input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /></div>',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'label_submit'         => esc_html__( 'Post comment', 'finder' ),
			'class_submit'         => 'btn btn-lg btn-primary rounded-pill',
			'cancel_reply_before'  => ' <span class="ms-3 h6">',
			'cancel_reply_after'   => '</span>',
			'comment_notes_after'  => '',
			'comment_notes_before' => sprintf(
				'<small>%s %s <span class="text-danger">*</span></small>',
				esc_html__( 'Your email address will not be published.', 'finder' ),
				/* translators: related to comment form; phrase follows by red mark*/
				esc_html__( 'Required fields are marked', 'finder' )
			),
		);

		$wrap_class = ( 'car-finder' === $style ) ? ' bg-faded-light' : ' bg-secondary';

		if ( 'car-finder' === $style ) {
			comment_form( $args );
		} elseif ( 'real-estate' === $style ) {
			?>
			<div class="card py-md-4 py-3 shadow-sm" id="comments">
				  <div class="card-body col-lg-8 col-md-10 mx-auto px-md-0 px-4">
					<?php comment_form( $args ); ?>
				  </div>
			</div>
			<?php
		} elseif ( 'default' === $style ) {
			?><div class="bg-secondary" id="comments">
				<div class="container py-md-2 py-lg-4">
					<div class="row">
						<div class=" col-lg-9 col-12 mx-auto">
							<div class="comment-wrap">
								<div class="px-sm-0 px-md-5 px-lg-0 py-5<?php echo esc_attr( $wrap_class ); ?>">
									<?php comment_form( $args ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><?php
		} else {
			?>
			<div class="bg-secondary" id="comments">
				<div class="container py-md-2 py-lg-4">
					<div class="row">
						<div class=" col-xl-8 col-12 mx-xl-n5">
							<div class="comment-wrap">
								<div class="px-sm-0 px-md-5 py-5<?php echo esc_attr( $wrap_class ); ?>">
									<?php comment_form( $args ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

// Single post related posts.
if ( ! function_exists( 'finder_single_post_recent_posts' ) ) {
	/**
	 * Display relaed post.
	 */
	function finder_single_post_recent_posts() {
		global $post;

		if ( ! finder_single_post_is_related_post_enabled() ) {
			return;
		}

		$style = finder_get_blog_single_style();

		$categories = get_the_category( $post->ID );

		if ( $categories ) {
			$category_ids = array();

			foreach ( $categories as $category ) {
				$category_ids[] = $category->term_id;
			}

			$related_articles_query_args = apply_filters(
				'finder_related_articles_query_args',
				array(
					'category__in'   => $category_ids,
					'post__not_in'   => array( $post->ID ),
					'posts_per_page' => get_theme_mod( 'finder_related_posts_per_page_options', 4 ),
					'post_type'      => 'post',
				),
				$category_ids
			);
		} else {

			$related_articles_query_args = apply_filters(
				'finder_single_post_related_articles_query_args',
				array(
					'post_type'      => 'post',
					'posts_per_page' => get_theme_mod( 'finder_related_posts_per_page_options', 4 ),
					'post__not_in'   => array( $post->ID ),
				)
			);
		}

		$carousel_args = apply_filters(
			'finder_related_posts_carousel_args',
			array(
				'controls'   => false,
				'gutter'     => 24,
				'autoHeight' => true,
				'responsive' => array(
					'0'    => array(
						'items' => 1,
						'nav'   => true,
					),
					'500'  => array(
						'items' => 2,
					),
					'850'  => array(
						'items' => 3,
					),
					'1200' => array(
						'items' => get_theme_mod( 'finder_related_posts_column_options', 3 ),
					),

				),
			)
		);

		$related_articles_query = new WP_Query( $related_articles_query_args );

		if ( $related_articles_query->have_posts() ) :

			$realted_post_title = get_theme_mod( 'finder_related_posts_title_text', esc_html__( 'You may be also interested in', 'finder' ) );
			$realted_post_link  = get_theme_mod( 'finder_related_posts_link_text', esc_html__( 'Go to blog', 'finder' ) );

			$action_text_url = get_theme_mod( 'finder_related_posts_action_text_url' );

			if ( ! $action_text_url ) {
				$action_text_url = finder_get_blog_page_permalink();
			}

			$realted_post_title_class = ( 'car-finder' === $style ) ? ' h3 mb-sm-0 text-light' : ' h3 mb-sm-0';
			$realted_post_link_class  = ( 'car-finder' === $style ) ? ' text-light' : '';
			?>
			<div class="mt-md-4 mb-4">
				<div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
					<h2 class="<?php echo esc_attr( $realted_post_title_class ); ?>"><?php echo esc_html( $realted_post_title ); ?></h2>
					<a class="btn btn-link fw-normal ms-sm-3 p-0<?php echo esc_attr( $realted_post_link_class ); ?>" href="<?php echo esc_url( $action_text_url ); ?>"><?php echo esc_html( $realted_post_link ); ?><i class="fi-arrow-long-right ms-2"></i></a>
				</div>
				<div class="tns-carousel-wrapper tns-nav-outside">
					<div class="tns-carousel-inner d-block" data-carousel-options="<?php echo esc_attr( wp_json_encode( $carousel_args ) ); ?>">
						<?php
						while ( $related_articles_query->have_posts() ) :
							$related_articles_query->the_post();
							?>
							<article>
								<a class="dblock- mb-3" href="<?php the_permalink(); ?>"><div class="aspect-ratio aspect-w-219 aspect-h-100"><?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-center object-cover rounded-3' ) ); ?></div></a>
								<?php
								$title_class = ( 'car-finder' === $style ) ? ' nav-link-light' : ' nav-link';
								$link_class  = 'fs-xs text-uppercase text-decoration-none';
								$categories  = get_the_category();
								foreach ( $categories as $category ) {
									?>
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
										<?php echo esc_html( $category->name ); ?>
									</a>
									<?php
								}
								?>
								<?php
								$author_title_class = ( 'car-finder' === $style ) ? ' text-light' : ' text-nav';
								$comment_meta_class = ( 'car-finder' === $style ) ? ' text-light' : ' text-body';
								?>
								<h3 class="fs-base pt-1"><a class="<?php echo esc_attr( $title_class ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<a class="d-flex align-items-center text-decoration-none" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'rounded-circle loaded tns-complete' ) ); ?>
									<div class="ps-2">
										<h6 class="fs-sm lh-base mb-1<?php echo esc_attr( $author_title_class ); ?>"><?php echo esc_html( get_the_author() ); ?></h6>
										<div class="d-flex fs-xs<?php echo esc_attr( $comment_meta_class ); ?>">
											<span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i><?php echo get_the_date( 'M j' ); ?></span>
											<span><i class="fi-chat-circle opacity-70 mt-n1 me-1 align-middle"></i><?php finder_single_post_comments_count(); ?></span>
										</div>
									</div>
								</a>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_blog_single_sidebar' ) ) {
	/**
	 * Archive blog sidebar.
	 */
	function finder_blog_single_sidebar() {
		$blog_single_style  = finder_get_blog_single_style();
		$blog_single_layout = finder_get_blog_single_layout();

		if ( 'full-width' === $blog_single_layout ) {
			return;
		}

		$column_classes = 'blog-sidebar-widgets col-lg-4';
		// $column_classes .= 'city-guide' === $blog_single_style ? ' col-lg-3' : ' col-lg-4';

		$offcanvas_header_class = 'city-guide' === $blog_single_style ? ' shadow-sm mb-2' : ' bg-transparent border-bottom border-light';
		$button_class           = 'car-finder' === $blog_single_style ? ' btn-close-white' : '';

		if ( 'left-sidebar' === $blog_single_layout ) {
			$column_classes .= ' order-first';
		}
		$offcanvas_wrap_class = 'offcanvas offcanvas-collapse';
		if ( 'left-sidebar' === $blog_single_layout ) {
			$offcanvas_wrap_class .= ' offcanvas-start';
		} else {
			$offcanvas_wrap_class .= ' offcanvas-end';
		}
		if ( 'car-finder' === $blog_single_style ) {
			$offcanvas_wrap_class .= ' bg-dark';
		}

		if ( 'city-guide' === $blog_single_style || 'job-board' === $blog_single_style || 'car-finder' === $blog_single_style ) {
			?>
			<aside class="<?php echo esc_attr( $column_classes ); ?>">
				<div class="<?php echo esc_attr( $offcanvas_wrap_class ); ?>" id="blog-sidebar">
					<div class="offcanvas-header <?php echo esc_attr( $offcanvas_header_class ); ?>">
						<h2 class="h5 <?php echo esc_attr( 'car-finder' === $blog_single_style ? 'text-light mb-0 ' : ' offcanvas-title' ); ?>"><?php esc_html_e( 'Sidebar', 'finder' ); ?></h2>
						<button class="btn-close <?php echo esc_attr( $button_class ); ?>" type="button" data-bs-dismiss="offcanvas"></button>
					</div>
					<?php if ( is_active_sidebar( 'blog-single-sidebar' ) ) : ?>
						<div class="offcanvas-body">
							<?php
							/**
							 * Functions hooked into finder_single_post_after_footer_job_board_demo action.
							 *
							 * @hooked finder_single_post_author_sidebar - 10
							 *
							 * @hooked finder_search_form - 20
							 */
							do_action( 'finder_before_sidebar' );
							?>
							<?php dynamic_sidebar( 'blog-single-sidebar' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php finder_sidebar_button(); ?>
			</aside>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_the_single_post_meta' ) ) {
	/**
	 * Display the post meta information.
	 *
	 * @param string $view The view of the single post.
	 */
	function finder_the_single_post_meta( $view = 'default' ) {
		$post_infos = apply_filters( 'finder_single_post_meta_infos', array( 'categories', 'date', 'read', 'comments', 'author' ) );
		?>
		<div class="d-flex flex-wrap border-bottom pb-3 divide-x-gap-[16px]">
		<?php
		foreach ( $post_infos as $post_info ) :
			finder_the_post_meta( $post_info, 'single-post-default', '<div class="d-flex align-items-center mb-2">', '</div>' );
		endforeach;
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_the_post_thumbnail' ) ) {
	/**
	 * Display the post thumbnail with aspect ratio.
	 *
	 * @param string|int[] $size   Optional. Image size. Accepts any registered image size name, or an array of width and height values in pixels (in that order). Default 'post-thumbnail'.
	 * @param string|array $attr   Optional. Query string or array of attributes. Default empty.
	 * @param string       $width  Optional. Width of the image aspect ratio.
	 * @param string       $height Optional. Height of the image aspect ratio.
	 */
	function finder_the_post_thumbnail( $size = 'post-thumbnail', $attr = '', $width = '', $height = '' ) {
		if ( has_post_thumbnail() ) {
			if ( empty( $height ) && empty( $width ) ) {
				the_post_thumbnail( $size, $attr );
			} else {
				$wrap_class = 'aspect-ratio aspect-w-' . $width . ' aspect-h-' . $height;
				$img_class  = 'w-full h-full object-center object-cover';

				if ( isset( $attr['class'] ) ) {
					$attr['class'] .= ' ' . $img_class;
				} else {
					$attr['class'] = $img_class;
				}
				?>
				<div class="<?php echo esc_attr( $wrap_class ); ?>">
					<?php the_post_thumbnail( $size, $attr ); ?>
				</div>
				<?php
			}
		}
	}
}

// Single post date.
if ( ! function_exists( 'finder_single_post_date' ) ) {
	/**
	 * Display single post date.
	 */
	function finder_single_post_date() {
		$style = finder_get_blog_single_style();

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published d-none" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s %5$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'Y-m-d' ) ),
			esc_html( get_the_date( 'M j' ) ),
			esc_attr( get_the_modified_date( 'Y-m-d' ) ),
			esc_html( get_the_modified_date( 'M j' ) ),
			get_the_time()
		);

		$output_time_string = sprintf( '<span>%1$s</span>', $time_string );
		$posted_on_class    = ( ( 'car-finder' === $style ) && ( 'real-estate' !== $style ) ) ? 'border-light text-light' : '';
		if ( 'real-estate' === $style ) {
			$posted_on = '<li class="me-3"><i class="fi-calendar-alt me-2 mt-n1 opacity-60"></i>' . $output_time_string . '</li>';
		} else {
			$posted_on = '<div class="d-flex align-items-center border-end pe-3 me-3 mb-2 ' . $posted_on_class . '" ><i class="fi-calendar-alt opacity-70 me-2"></i>' . $output_time_string . '</div>';
		}

		echo wp_kses(
			$posted_on,
			array(
				'span' => array(
					'class' => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
				'div'  => array(
					'class' => array(),
				),
				'i'    => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
	}
}

// Single post comments count.
if ( ! function_exists( 'finder_single_post_comments_count' ) ) {
	/**
	 * Display single post comments_count.
	 */
	function finder_single_post_comments_count() {
		$comments_number = get_comments_number();

		if ( 0 === (int) $comments_number ) {
			echo esc_html__( 'Leave a comment', 'finder' );
		} else {
			echo esc_html(
				sprintf(
					/* translators: 1: number of comments, 2: post title */
					esc_html( _nx( '%1$s comment', '%1$s comments', $comments_number, 'comments title', 'finder' ) ),
					number_format_i18n( $comments_number )
				)
			);
		}
	}
}

// Single post excerpt.
if ( ! function_exists( 'finder_single_post_excerpt' ) ) {
	/**
	 * Display single post excerpt.
	 */
	function finder_single_post_excerpt() {
		$style          = finder_get_blog_single_style();
		$text_color     = ( 'car-finder' === $style ) ? 'text-light' : 'text-dark';
		$custom_excerpt = get_the_excerpt();
		if ( has_excerpt() ) {
			if ( 'real-estate' === $style ) {
				?>
				<h6><?php echo wp_kses_post( $custom_excerpt ); ?></h6>
				<?php
			} else {
				?>
				<p class="fs-lg fw-bold mb-4 <?php echo esc_attr( $text_color ); ?>"><?php echo wp_kses_post( $custom_excerpt ); ?></p>
				<?php
			}
		}
	}
}

// Single post tags.
if ( ! function_exists( 'finder_single_post_tag' ) ) {
	/**
	 * Display single post tag.
	 *
	 * @param string $style The single post style.
	 */
	function finder_single_post_tag( $style = 'real-estate' ) {

		if ( empty( $style ) ) {
			$style = finder_get_blog_single_style();
		}

		$wrapper_class = ( 'car-finder' === $style ) ? ' text-light' : ' d-none d-sm-block';
		$link_class    = ( ( 'car-finder' === $style ) ) ? 'btn-translucent-light' : 'btn-outline-secondary';

		$tags = get_the_tags();

		$i = 1;

		if ( has_tag() ) {
			?>
			<div class="d-flex align-items-center me-3 mb-3 mb-md-0">
				<div class="fw-bold text-nowrap mb-2 me-2 pe-1<?php echo esc_attr( $wrapper_class ); ?>"><?php echo esc_html__( 'Tags:', 'finder' ); ?></div>
				<div class="d-flex flex-wrap">
					<?php
					foreach ( $tags as $tag ) :
						if ( apply_filters( 'finder_single_post_tag_hash_prefix', false ) ) {
							$tag_name = '#' . $tag->name;
						} else {
							$tag_name = $tag->name;
						}

						$margin_class = '';
						if ( count( $tags ) !== $i ) {
							$margin_class = ' me-2';
						}

						?>
						<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="btn btn-xs rounded-pill fs-sm fw-normal mb-2 
											<?php
											echo esc_attr( $link_class );
											echo esc_attr( $margin_class );
											?>
						" rel="tag">
							<?php echo esc_html( $tag_name ); ?>
						</a>
						<?php $i++; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}

// Single post featured image.
if ( ! function_exists( 'finder_single_post_featured_image' ) ) {
	/**
	 * Display single post featured image.
	 */
	function finder_single_post_featured_image() {

		$cover_image = finder_acf_cover_image();
		$style       = finder_get_blog_single_style();

		if ( has_post_thumbnail() || ! empty( $cover_image ) ) {
			if ( 'real-estate' === $style ) {
				?>
				<div class="col-lg-10 col-md-10 mx-auto mb-4 pb-md-3 d-flex align-items-center justify-content-center">
				<?php
			}
			if ( 'city-guide' === $style || 'job-board' === $style || 'car-finder' === $style ) {
				?>
				<div class="city-guide">
				<?php
			}
			if ( ! empty( $cover_image ) ) {
				?>
				<img class="rounded-3 w-full h-full" src="<?php echo esc_url( $cover_image ); ?>" alt="<?php echo esc_attr__( 'cover-image', 'finder' ); ?>">
				<?php
			} elseif ( has_post_thumbnail() ) {
				the_post_thumbnail( 'full', array( 'class' => 'rounded-3 w-full h-full' ) );
			}
			if ( 'real-estate' === $style ) {
				?>
				</div>
				<?php
			}
			if ( 'city-guide' === $style || 'job-board' === $style || 'car-finder' === $style ) {
				?>
				</div>
				<?php
			}
		}
	}
}

// Single post content.
if ( ! function_exists( 'finder_single_post_content' ) ) {
	/**
	 * Display single post content.
	 */
	function finder_single_post_content() {
		?>
		<div class="prose clearfix"><?php the_content(); ?></div>
		<?php
	}
}


// Single post Author.
if ( ! function_exists( 'finder_single_post_author_sidebar' ) ) {
	/**
	 * Display single post author info.
	 */
	function finder_single_post_author_sidebar() {
		$style         = finder_get_blog_single_style();
		$byline        = finder_acf_single_post_author_by_line();
		$card_class    = 'card card-flush mb-4 ';
		$flex_class    = 'd-flex align-items-start ';
		$heading_class = 'h5 mb-2 ';
		$desc_class    = 'fs-sm ';

		if ( 'car-finder' === $style ) {
			$card_class    .= 'bg-transparent border-light';
			$flex_class    .= 'pt-3 pt-lg-0';
			$heading_class .= 'text-light';
			$desc_class    .= 'text-light opacity-70';
		} else {
			$card_class .= 'pb-3 pb-lg-0 mb-4';
			$desc_class .= 'text-muted';
		}

		?>
		<div class="<?php echo esc_attr( $card_class ); ?>">
			<div class="card-body">
				<div class="<?php echo esc_attr( $flex_class ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', 'avatar', array( 'class' => 'rounded-circle' ) ); ?>
					  <div class="ps-3">
						<h3 class="<?php echo esc_attr( $heading_class ); ?>"><?php echo esc_html( get_the_author() ); ?></h3>
						<p class="<?php echo esc_attr( $desc_class ); ?>"><?php echo esc_html( $byline ); ?></p>
											 <?php
												finder_user_social_profile_links();
												?>
					  </div>
				</div>
			  </div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_search_form' ) ) {
	/**
	 * Finder Search Form.
	 */
	function finder_search_form() {
		$echo       = apply_filters( 'finder_search_form', true );
		$style      = finder_get_blog_single_style();
		$form_class = 'form-control ';
		if ( 'car-finder' === $style ) {
			$form_class .= 'form-control-light';
		}
		if ( $echo ) {
			?>
			<form method="get" class="search-form position-relative mb-4" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="fi-search position-absolute top-50 end-0 translate-middle-y text-muted me-3"></i>
				<input type="search" class="<?php echo esc_attr( $form_class ); ?>"
					placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'finder' ); ?>"
					value="<?php echo get_search_query(); ?>" name="s"
					title="<?php echo esc_attr_x( 'Search for:', 'label', 'finder' ); ?>">
				<input type="hidden" class="form-control" name="post_type" value="post">
			</form>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_post_protected_password_form' ) ) :
	/**
	 * Display Post password protected form.
	 */
	function finder_post_protected_password_form() {
		global $post;

		$label = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
		?>

		<form class="protected-post-form input-group finder-protected-post-form flex-column" action="<?php echo esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
			<p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'finder' ); ?></p>
			<div class="d-flex align-items-center w-md-50">
				<label class="mb-0 me-3 d-none d-md-block" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'finder' ); ?></label>
				<div class="d-flex flex-grow-1">
					<input class="input-text form-control" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
					<input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo esc_attr( 'Submit' ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
				</div>
			</div>
		</form>
		<?php
	}
endif;

/**
* Function for Single Portfolio Social Icons
*/
if ( ! function_exists( 'finder_user_social_profile_links' ) ) :
	/**
	 * Function to display Single Portfolio Social Icons
	 */
	function finder_user_social_profile_links() {
		$style      = finder_get_blog_single_style();
		$link_class = 'btn btn-icon btn-xs rounded-circle me-2 ';
		if ( 'car-finder' === $style ) {
			$link_class .= 'btn-translucent-light';
		} else {
			$link_class .= 'btn-light-primary shadow-sm';
		}
		?>
		<div class="d-flex">
			<?php
				$social_media_profiles = trim( finder_user_social_links(), ' ' );

			if ( ! empty( $social_media_profiles ) ) {

				$profiles = explode( "\n", $social_media_profiles );

				$social_networks = [
					'www.facebook.com' => 'fi-facebook',
					'www.linkedin.com' => 'fi-linkedin',
					'twitter.com'      => 'fi-twitter',
				];

				if ( ! empty( $profiles ) ) {
					foreach ( $profiles as $social_profile ) {
						$parse = parse_url( $social_profile );
						$url   = isset( $parse['host'] ) ? $parse['host'] : '';
						?>
						<a href="<?php echo esc_url( $social_profile ); ?>" class="<?php echo esc_attr( $link_class ); ?>">
							<i class="<?php echo esc_attr( $social_networks[ $url ] ); ?>"></i>
						</a>
							<?php
					}
				}
			}
			?>
		</div>
		<?php
	}

endif;

if ( ! function_exists( 'finder_single_post_navigation' ) ) {
	/**
	 * Displays navigation for Single Posts
	 */
	function finder_single_post_navigation() {
		if ( apply_filters( 'finder_single_enable_post_navigation', filter_var( get_theme_mod( 'enable_post_navigation', true ), FILTER_VALIDATE_BOOLEAN ) ) ) {
			?>
		<div class="article__navigation">
			<div class="article__navigation--inner py-4 px-4 bg-secondary rounded">
			<div class="post-navigation d-md-flex justify-content-between align-items-center row">

				<?php
					$prev_post = get_previous_post();
					$next_post = get_next_post();
				?>
				<div class="col-md-6">
					<?php if ( $prev_post ) : ?>
						<a class="d-flex justify-content-center justify-content-md-start mb-4 mb-md-0 text-muted text-decoration-none text-break" href="<?php the_permalink( $prev_post ); ?>">
							<div class="related-nav__arrow me-3">
								<i class="fi fi-arrow-long-left fs-sm"></i>
							</div>
							<div class="related-nav__content">
								<span class="prev fs-sm fw-normal text-uppercase"><?php echo esc_html__( 'Prev', 'finder' ); ?></span>
								<div class="text-dark pt-md-1 font-weight-normal mb-0">
									<?php echo wp_kses( get_the_title( $prev_post ), 'post-title' ); ?>
								</div>
							</div>
						</a>
					<?php endif; ?>
				</div>
				
				<div class="col-md-6">
				<?php if ( $next_post ) : ?>
					<a class="d-flex justify-content-center justify-content-md-end text-muted text-decoration-none text-break" href="<?php the_permalink( $next_post ); ?>">
						<div class="related-nav__content text-end">
							<span class="next fw-normal fs-sm text-uppercase"><?php echo esc_html__( 'Next', 'finder' ); ?></span>
							<div class="text-dark fw-normal mb-0 text-right pt-md-1"> 
								<?php echo wp_kses( get_the_title( $next_post ), 'post-title' ); ?>
							</div>       
						</div>
						<div class="related-nav__arrow ms-3">
							<i class="fi fi-arrow-long-right font-size-15"></i>
						</div>

					</a>
				   
				<?php endif; ?>
			</div>

			</div>
		</div>
	</div>
			<?php
		}
	}
}



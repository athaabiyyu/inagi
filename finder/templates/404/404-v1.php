<?php
/**
 * The template for displaying 404 page (not found) for V1.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Finder
 */

$page_variant         = get_theme_mod( 'finder_404_version' );
$primary_button_color = apply_filters( 'finder_404_primary_button_color', 'btn-' . get_theme_mod( 'finder_404_primary_button_color', 'primary' ) );
$primary_button_text  = apply_filters( 'finder_404_primary_button_text', get_theme_mod( 'finder_404_primary_button_text', 'Go to homepage' ) );
$primary_button_url   = apply_filters( 'finder_404_primary_button_url', get_theme_mod( 'finder_404_primary_button_url', '#' ) );
$primary_button_size  = apply_filters( 'finder_404_primary_button_size', 'btn-' . get_theme_mod( 'finder_404_primary_button_size', 'lg' ) );
$primary_button_shape = apply_filters( 'finder_404_primary_button_shape', get_theme_mod( 'finder_404_primary_button_shape', '' ) );

$btn_classes = array(
	'404_primary_button_text',
	'btn',
	$primary_button_size,
	$primary_button_color,
	'w-sm-auto',
	'w-100',
	'mb-3',
	'me-sm-4',
);

if ( $primary_button_shape ) {
	$btn_classes[] = $primary_button_shape;
}

$link_button_color   = apply_filters( 'finder_404_link_button_color', get_theme_mod( 'finder_404_link_button_color', 'light' ) );
$link_button_text    = apply_filters( 'finder_404_link_button_text', get_theme_mod( 'finder_404_link_button_text', 'Visit help center' ) );
$link_button_url     = apply_filters( 'finder_404_link_button_url', get_theme_mod( 'finder_404_link_button_url', '#' ) );
$link_button_size    = apply_filters( 'finder_404_link_button_size', 'btn-' . get_theme_mod( 'finder_404_link_button_size', 'lg' ) );
$link_button_shape   = apply_filters( 'finder_404_link_button_shape', get_theme_mod( 'finder_404_link_button_shape', '' ) );
$link_button_variant = apply_filters( 'finder_404_link_button_variant', get_theme_mod( 'finder_404_link_button_variant', 'outline' ) );
$enable_secondary_button = apply_filters( 'finder_404_enable_secondary_button', get_theme_mod( 'finder_404_enable_secondary_button', 'no' ) );

$link_button_variant = ! empty( $link_button_variant ) ? 'btn-' . $link_button_variant . '-' . $link_button_color : 'btn-' . $link_button_color;

$link_btn_classes = array(
	'404_link_button_text',
	'btn',
	$link_button_size,
	$link_button_variant,
	'w-sm-auto',
	'w-100',
	'mb-3',
);

if ( $link_button_shape ) {
	$link_btn_classes[] = $link_button_shape;
}

?>
<section class="d-flex align-items-lg-center align-items-end position-relative min-vh-100 py-lg-5 py-0">
	<!-- Bg overlay-->
	<span class="position-absolute top-0 start-0 d-lg-block d-none w-100 h-100 zindex-1 bg-dark rounded-4 rounded-start-0" style="max-width: 43.6vw;"></span>
	<!-- Overlay content-->
	<div class="container position-relative zindex-5">
		<div class="row align-items-md-center gy-4">
			<div class="col-lg-4 order-lg-1 order-2 position-relative py-lg-0 py-5 text-lg-start text-center">
				<!-- Bg overlay (mobile)-->
				<span class="position-absolute top-0 start-0 d-lg-none d-block w-100 h-100 zindex-1 bg-dark rounded-bottom-0 rounded-4"></span>
				<!-- Overlay content-->
				<div class="position-relative zindex-5">
					<?php if ( get_theme_mod( 'finder_404_title' ) !== '' ) : ?>
						<h1 class="404_title display-3 text-light"><?php echo esc_html( get_theme_mod( 'finder_404_title', esc_html_x( 'Page Not Found.', 'front-end', 'finder' ) ) ); ?></h1>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'finder_404_description' ) !== '' ) : ?>
						<p class="404_desc mb-lg-4 mb-3 pb-lg-3 fs-lg text-light opacity-70">
							<?php
								echo esc_html(
									get_theme_mod(
										'finder_404_description',
										_x(
											'
                                            Sorry, we can’t find the page you are looking for. We suggest you go to homepage while we are fixing the problem.',
											'front-end',
											'finder'
										)
									)
								)
							?>
						</p>
					<?php endif; ?>
					<svg class="d-lg-block d-none mb-4" xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none">
						<g clip-path="url(#A)">
							<path d="M47.528 78.373l2.641-20.003c.184-1.252-1.518-2.086-2.26-1.01l-4.593 5.777c-.174-2.527.866-4.482 2.265-6.703.52-.977.941-2.176.224-3.184-1.083-1.589-3.847-1.469-5.558-1.607-4.352-.339-8.728-.136-13.056-1.017-4.97-1.126-2.991-3.713.035-5.864 3.163-2.319 6.913-4.157 10.556-5.521 6.4-2.332 13.358-4.488 18.447-9.158 2.827-2.594 4.961-8.281 1.13-11.14-4.67-3.546-12.626-4.453-18.315-3.502-3.054.303-22.941 5.054-17.949-2.922 3.662-5.839 13.323-8.726 19.502-10.959.817-.312.459-1.588-.373-1.428-6.575 1.347-13.373 4.335-18.744 8.493-2.857 2.289-6.13 8.166-1.206 10.376 5.732 2.593 13.172-.151 19.082-1.201 3.704-.753 8.017-.025 11.636.696 7.711 1.548 6.706 7.74 1.374 11.508-6.562 4.585-14.833 5.945-21.875 9.575-2.49 1.327-11.014 5.566-9.116 9.928 2.195 5.026 11.153 4.368 15.558 4.47-.237-.054 7.17-.018 6.803.944s-1.124 1.885-1.643 2.862c-.971 1.87-1.331 3.68-1.065 5.581-1.526-1.391-3.19-2.614-4.991-3.669-.977-.52-2.093.67-1.765 1.64 2.584 6.607 7.406 11.68 11.082 17.639.48.955 2.061.566 2.177-.602zM41.97 66.663c.504.413 1.015.13 1.207-.274.389.038.764-.076 1.039-.412l2.751-3.358-1.498 12.102c-2.433-3.537-5.157-6.891-7.147-10.626l3.648 2.568z" fill="#fff"></path>
						</g>
						<defs>
							<clipPath id="A">
								<path fill="#fff" d="M0 0h80v80H0z"></path>
							</clipPath>
						</defs>
					</svg>
					<div class="pt-3">
						<a
							<?php
								finder_render_attr(
									'btn_classes',
									array(
										'href'  => $primary_button_url,
										'class' => join(
											' ',
											$btn_classes
										),
									)
								);
								?>
						><?php echo esc_html( $primary_button_text ); ?>
						</a>
						<?php if( 'yes' === $enable_secondary_button ) : ?>
						<a
							<?php
								finder_render_attr(
									'btn_classes',
									array(
										'href'  => $link_button_url,
										'class' => join(
											' ',
											$link_btn_classes
										),
									)
								);
								?>
						><?php echo esc_html( $link_button_text ); ?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 offset-lg-2 order-lg-2 order-1">
				<div class="ratio ratio-1x1 mx-auto" style="max-width: 636px;">
				<?php
					$image_option = wp_get_attachment_image(
						get_theme_mod( 'finder_404_image_option' ),
						'480px',
						false,
						array(
							'class' => 'w-100',
							'alt'   => esc_html_x( 'Page Not Found', 'front-end', 'finder' ),
						)
					);
					if ( '' !== $image_option ) :
						echo wp_kses_post( apply_filters( '404_image_option', $image_option ) );
					else :
						?>
					<lottie-player src="<?php echo esc_attr( FINDER_THEME_URI . 'assets/json/animation-real-estate-404.json' ); ?>" background="transparent" speed="1" loop autoplay></lottie-player>
						<?php
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>

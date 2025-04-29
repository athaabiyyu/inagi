<?php
/**
 * The template for displaying 404 page (not found) for V2.
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
<section class="d-flex align-items-center position-relative min-vh-100 py-5">
	<!-- Bg overlay-->
	<span class="position-absolute top-50 start-50 translate-middle zindex-1 rounded-circle mt-sm-0 mt-n5" style="width: 50vw; height: 50vw; background-color: rgba(83, 74, 117, 0.3); filter: blur(6.4vw);"></span>
	<!-- Overlay content-->
	<div class="container d-flex justify-content-center position-relative zindex-5 text-center">
		<div class="col-lg-8 col-md-10 col-12 px-0">
			<?php if ( get_theme_mod( 'finder_404_title' ) !== '' ) : ?>
				<h1 class="404_title display-1 mb-lg-5 mb-4 text-light">
					<?php echo esc_html( get_theme_mod( 'finder_404_title', esc_html_x( 'Page Not Found.', 'front-end', 'finder' ) ) ); ?></h1>
				<?php
				endif;
			?>
			<div class="ratio ratio-16x9 mx-auto mb-lg-5 mb-4 py-4" style="max-width: 556px;">
				<?php
					$image_option = wp_get_attachment_image(
						get_theme_mod( 'finder_404_image_option' ),
						'480px',
						false,
						array(
							'class' => 'w-100',
							'alt'   => esc_html_x( 'Oops', 'front-end', 'finder' ),
						)
					);
					if ( '' !== $image_option ) :
						echo wp_kses_post( apply_filters( '404_image_option', $image_option ) );
					else :
						?>
						<lottie-player class="py-4" src="<?php echo esc_attr( FINDER_THEME_URI . 'assets/json/animation-car-finder-404.json' ); ?>" background="transparent" speed="1" loop autoplay></lottie-player>
						<?php
					endif;
					?>
			</div>
			<?php if ( get_theme_mod( 'finder_404_description' ) !== '' ) : ?>
				<p class="404_desc h2 mb-lg-5 mb-4 pb-2 text-light">
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
			<?php if ( 'yes' === $enable_secondary_button ) : ?>
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
</section>

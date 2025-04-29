<?php
/**
 * The template for displaying 404 page (not found) for V3.
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Finder
 */

$page_variant = get_theme_mod( 'finder_404_version' );
$title_tag    = '<span class="text-nowrap">:(</span>';
$contact_link = '<a href="#">' . esc_html__( 'homepage', 'finder' ) . '</a>.';
?>
<section class="d-flex align-items-center position-relative min-vh-100 pt-sm-5 pt-4 pb-5" style="background: radial-gradient(95.96% 126.3% at 88.07% 109.91%, #F4F1FF 6.21%, #F5F4F8 40.55%, rgba(245, 244, 248, 0) 100%);">
	<div class="container">
		<div class="row gy-4">
			<div class="col-md-5 align-self-sm-end mt-lg-5 pt-lg-5">
				<div class="ratio ratio-1x1 mx-auto" style="max-width: 526px;">
					<?php
						$image_option = wp_get_attachment_image(
							get_theme_mod( 'finder_404_image_option' ),
							'480px',
							false,
							array(
								'class' => 'w-100',
								'alt'   => esc_html_x( 'Whoops', 'front-end', 'finder' ),
							)
						);
						if ( '' !== $image_option ) :
							echo wp_kses_post( apply_filters( '404_image_option', $image_option ) );
						else :
							?>
							<lottie-player src="<?php echo esc_attr( FINDER_THEME_URI . 'assets/json/animation-job-board-404.json' ); ?>" background="transparent" speed="1" loop autoplay></lottie-player>
							<?php
						endif;
						?>
				</div>
			</div>
			<div class="col-lg-5 col-md-6 offset-lg-2 offset-md-1 text-md-start text-center">
				<?php if ( get_theme_mod( 'finder_404_title' ) !== '' ) : ?>
					<h1 class="404_title display-3 mb-4 pb-md-3">
						<?php
							echo wp_kses_post(
								get_theme_mod(
									'finder_404_title',
									sprintf( /* translators: %s: search term */
										__( 'Page Not Found. %s', 'finder' ),
										$title_tag
									)
								)
							);
						?>
					</h1>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'finder_404_description' ) !== '' ) : ?>
					<p class="404_desc lead mb-md-5 mb-4">
						<?php
						/* translators: %s: search term */
							echo wp_kses_post(
								get_theme_mod(
									'finder_404_description',
									sprintf(/* translators: %s: search term */
										esc_html__( 'Sorry, we can’t find the page you are looking for. We suggest you go to homepage while we are fixing the problem. %s', 'finder' ),
										$contact_link
									)
								)
							);
						?>
					</p>
				<?php endif; ?>
				<!-- Search form-->
				<form method="get" class="form-group rounded-pill" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="input-group input-group-lg">
						<input class="form-control" type="text" name="s" placeholder="<?php esc_attr_e( 'Your search keywords...', 'finder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
					</div>
					<button class="btn btn-primary btn-lg rounded-pill" type="submit"><?php esc_html_e( 'Search', 'finder' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
/**
 * The Template for user login link
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();

$btn_classes = 'btn btn-sm d-none d-lg-block order-lg-3';
if ( finder_is_header_navbar_dark() ) {
	$btn_classes .= ' btn-link btn-light';
} else {
	$btn_classes .= ' text-primary';
}

if ( is_user_logged_in() ) :
	?>
	<div class="dropdown d-none d-lg-block order-lg-3 my-n2 me-3">
		<a class="d-block py-2 text-decoration-none account-toogle" href="<?php echo esc_url( hivepress()->router->get_url( 'user_account_page' ) ); ?>">
			<?php echo get_avatar( $user->ID, 40, '', '', array( 'class' => 'rounded-circle' ) ); ?>
			<?php if ( apply_filters( 'finder_header_user_account_name_toggle', false ) ) : ?>
				<span class="fw-bold ms-2 text-dark"><?php echo esc_html( $user->display_name ); ?></span>
			<?php endif; ?>
		</a>
		<?php finder_header_myaccount_dropdown_items(); ?>
	</div>
<?php else : ?>
	<a href="#user_login_modal" class="<?php echo esc_attr( $btn_classes ); ?>" data-bs-toggle="modal">
		<i class="fi-user me-2"></i>
		<?php esc_html_e( 'Sign in', 'finder' ); ?>
	</a>
	<?php
endif;

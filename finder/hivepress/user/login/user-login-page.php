<?php
/**
 * The Template for user login page
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use HivePress\Forms\User_Login;
use HivePress\Forms\User_Register;
use HivePress\Forms\User_Password_Request;

$listing_login_form_args = apply_filters(
	'finder_listing_form_login_page_args',
	array(
		'model'  => 'user',
		'button' => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-2', 'mb-2' ),
			),
		),
		'fields' => array(
			'username_or_email' => array(
				'placeholder' => esc_html__( 'Enter your email', 'finder' ),
				'attributes'  => array(
					'class' => array( 'mb-4' ),
				),
			),
			'password'          => array(
				'placeholder' => esc_html__( 'Enter password', 'finder' ),
			),
		),
	)
);

$login_form = new User_Login( $listing_login_form_args );

$listing_register_form_args = apply_filters(
	'finder_listing_form_register_page_args',
	array(
		'model'  => 'user',
		'button' => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-2', 'mb-2' ),
			),
		),
		'fields' => array(
			'email'    => array(
				'placeholder' => esc_html__( 'Enter your email', 'finder' ),
				'attributes'  => array(
					'class' => array( 'mb-4' ),
				),
			),
			'password' => array(
				'placeholder' => esc_html__( 'Enter password', 'finder' ),
			),
		),
	)
);

$register_form = new User_Register( $listing_register_form_args );

$reset_password_form_args = array(
	'button'      => array(
		'label'      => esc_html__( 'Send email', 'finder' ),
		'attributes' => array(
			'class' => array( 'btn', 'btn-primary', 'btn-lg', 'w-100', 'mt-2', 'mb-2' ),
		),
	),
	'fields'      => array(
		'username_or_email' => array(
			'placeholder' => esc_html__( 'Enter your email', 'finder' ),
			'attributes'  => array(
				'class' => array( 'mb-4' ),
			),
		),
	),
	'description' => 'Please enter your username or email address, you will receive a link to create a new password via email.',
);

$reset_password_form = new User_Password_Request( $reset_password_form_args );

$sticky_header   = finder_is_sticky_header();
$container_class = 'my-5 py-5';
$padding_class   = 'mt-5 mb-1 pt-5';
$card_wrap       = 'mb-4';

if ( ! $sticky_header ) {
	$container_class = 'mt-1 mb-4 pt-4 pb-5';
	$padding_class   = 'mt-5 mb-1 pt-5';
	$card_wrap       = 'mb-5';
}
?>
<div class="container <?php echo esc_attr( $container_class ); ?>">
	<div class="d-flex justify-content-center <?php echo esc_attr( $padding_class ); ?>">
		<div class="col-xl-5 col-lg-6 col-md-8 col-12 mx-auto">
			<div id="login_modal" class="view card p-4 <?php echo esc_attr( $card_wrap ); ?>">
				<h1 class="hp-page__title"><?php echo esc_html__( 'Sign In', 'finder' ); ?></h1>
				<?php echo apply_filters( 'finder_user_login_form_output', $login_form->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php if ( get_option( 'hp_user_enable_registration', true ) ) : ?>
					<p class="hp-form__action hp-form__action--user-register mt-3"><?php esc_html_e( 'Don\'t have an account yet?', 'finder' ); ?><a href="#register_modal" class="ms-1" data-bs-toggle="modal" data-bs-dismiss="modal"><?php esc_html_e( 'Register', 'finder' ); ?></a></p>
				<?php endif; ?>
				<a href="#password_request_modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="hp-form_action hp-form_action--user-password-request"><?php esc_html_e( 'Forgot password?', 'finder' ); ?></a>
			</div>
			<div class="modal fade" id="register_modal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 550px;">
					<div class="modal-content">
						<div class="modal-body px-0 py-2 py-sm-0">
							<button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
							<div class="row mx-0 align-items-center">
								<div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
									<h1 class="hp-page__title"><?php echo esc_html__( 'Register', 'finder' ); ?></h1>
									<div class="finder-hp-singup-popup-form">
										<?php echo apply_filters( 'finder_user_register_form_output', $register_form->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="password_request_modal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-md modal-dialog-centered p-2 my-0 mx-auto">
					<div class="modal-content">
						<div class="modal-body px-0 py-2 py-sm-0">
							<button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
							<div class="row mx-0 align-items-center">
								<div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
									<h1 class="hp-page__title"><?php echo esc_html__( 'Reset Password', 'finder' ); ?></h1>
									<?php echo apply_filters( 'finder_user_reset_password_form_output', $reset_password_form->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

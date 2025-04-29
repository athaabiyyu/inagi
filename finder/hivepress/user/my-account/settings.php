<?php
/**
 * The Template for my account settings
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use HivePress\Forms\User_Update;
use HivePress\Models\User;
use HivePress\Fields\Attachment_Upload;
use HivePress\Models;


$account_style = finder_hivepress_get_user_account_style();
$card_class    = '';
$bg_class      = '';
$header_class  = finder_hivepress_user_account_header_classes();
$sticky_header = finder_is_sticky_header();

if ( 'car-finder' === $account_style ) {
	$card_class = 'card-light';
}

$container_class = 'container pt-5 pb-lg-4 mt-5 mb-sm-2';

if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4 pt-2';
}


?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	<div>
		<?php
		if ( 'city-guide' === $account_style ) {
			?>
			<div class="pt-5">
			<?php
			finder_hivepress_sidebar_city_guide_listing();
			?>
			</div>
					<?php
					$user_update_form_args = array(
						'model'  => HivePress\Models\User::query()->get_by_id( get_current_user_id() ),
						'fields' => array(
							'first_name'       => array(
								'placeholder' => esc_html__( 'Enter your First Name', 'finder' ),
							),
							'last_name'        => array(
								'placeholder' => esc_html__( 'Enter your Last Name', 'finder' ),
							),
							'description'      => array(
								'label'       => esc_html__( 'Short bio', 'finder' ),
								'placeholder' => esc_html__( 'Enter your Bio', 'finder' ),
								'attributes'  => array(
									'rows' => 6,
								),
							),
							'email'            => array(
								'placeholder' => esc_html__( 'Enter your Email', 'finder' ),

							),
							'password'         => array(
								'placeholder' => esc_html__( 'Enter your Password', 'finder' ),

							),
							'current_password' => array(
								'placeholder' => esc_html__( 'Enter your Current Password', 'finder' ),

							),
						),
						'button' => array(
							'attributes' => array(
								'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-4' ),
							),
						),
					);

					$user_update_form = new User_Update( $user_update_form_args );

					$model = $user_update_form->get_model();

					$from_action = hivepress()->router->get_url(
						'user_update_action',
						array(
							'user_id' => $model->get_id(),
						)
					);

					$user_update_form_fields = $user_update_form->get_fields();

					$bio_field      = $user_update_form_fields['description'];
					$bio_field_args = $bio_field->get_args();

					$profile_image_field      = $user_update_form_fields['image'];
					$profile_image_field_args = $profile_image_field->get_args();

					$profile_image_field_formats = array();
					foreach ( $profile_image_field_args['formats'] as $format ) {
						$profile_image_field_formats[] = 'image/' . $format;
					}

					$fname_field      = $user_update_form_fields['first_name'];
					$fname_field_args = $fname_field->get_args();

					$lname_field      = $user_update_form_fields['last_name'];
					$lname_field_args = $lname_field->get_args();

					$email_field      = $user_update_form_fields['email'];
					$email_field_args = $email_field->get_args();

					$password_field      = $user_update_form_fields['password'];
					$password_field_args = $password_field->get_args();

					$current_password_field      = $user_update_form_fields['current_password'];
					$current_password_field_args = $current_password_field->get_args();
					?>
			<form data-model="user" data-id="<?php echo esc_attr( $model->get_id() ); ?>" data-message="<?php esc_attr_e( 'Changes have been saved.', 'finder' ); ?>" action="#" data-action="<?php echo esc_url( $from_action ); ?>" method="POST" data-component="form">

				<div class="hp-form__messages" data-component="messages"></div>
				<div class="card card-body p-4 p-md-5 shadow-sm">
					<?php
					finder_hivepress_sidebar_city_guide_content();
					?>
					<div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
						<div class="col-lg-9 col-md-9">
							<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Personal Info', 'finder' ); ?></h1>
						</div>
						<!-- <div class="col-lg-3 col-md-3">
							<label class="form-label pt-2" for="<?php //echo esc_attr( uniqid( $profile_image_field->get_name() ) ); ?>"><?php //echo esc_html( $profile_image_field->get_label() ); ?>
							<input type="file" name="image" id="<?php //echo esc_attr( uniqid( $profile_image_field->get_name() ) ); ?>" data-component="file-upload" data-name="image" data-url="<?php //echo esc_url( hivepress()->router->get_url( 'attachment_upload_action' ) ); ?>" accept="image/png, image/jpeg" class="hp-field hp-field--file">
								</label>
						</div> -->
					</div>
					<div class="border rounded-3 p-3 mb-4" id="user-info">
						<div class="border-bottom pb-3 mb-3">
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label  fw-bold"><?php echo esc_html( $fname_field->get_label() ); ?></label>
									<div id="<?php echo esc_attr( $fname_field->get_name() ); ?>-value">
										<?php
										if ( $fname_field->get_value() ) {
											echo esc_html( $fname_field->get_value() );
										} else {
											esc_html_e( 'Not specified', 'finder' );
										}
										?>
									</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $fname_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $fname_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
								<input class="form-control mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $fname_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $fname_field->get_name() ); ?>" value="<?php echo esc_attr( $fname_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $fname_field_args['placeholder'] ); ?>">
							</div>
						</div>

						<div class="border-bottom pb-3 mb-3">
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label  fw-bold"><?php echo esc_html( $lname_field->get_label() ); ?></label>
									<div id="<?php echo esc_attr( $lname_field->get_name() ); ?>-value">
										<?php
										if ( $lname_field->get_value() ) {
											echo esc_html( $lname_field->get_value() );
										} else {
											esc_html_e( 'Not specified', 'finder' );
										}
										?>
									</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $lname_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $lname_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
								<input class="form-control mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $lname_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $lname_field->get_name() ); ?>" value="<?php echo esc_attr( $lname_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $lname_field_args['placeholder'] ); ?>">
							</div>
						</div>
						<div class="border-bottom  pb-3 mb-3">
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label fw-bold"><?php echo esc_html( $bio_field->get_label() ); ?></label>
									<div id="<?php echo esc_attr( $bio_field->get_name() ); ?>-value">
										<?php
										if ( $bio_field->get_value() ) {
											echo esc_html( $bio_field->get_value() );
										} else {
											esc_html_e( 'Not specified', 'finder' );
										}
										?>
									</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link py-0 collapsed" href="#<?php echo esc_attr( $bio_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $bio_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
								<input class="form-control mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $bio_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $bio_field->get_name() ); ?>" value="<?php echo esc_attr( $bio_field->get_value() ); ?>" rows="<?php echo esc_attr( $bio_field_args['attributes']['rows'] ); ?>" placeholder="<?php echo esc_attr( $bio_field_args['placeholder'] ); ?>">
							</div>
						</div>
						<div class="border-bottom pb-3 mb-3">
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label fw-bold"><?php echo esc_html( $email_field->get_label() ); ?></label>
									<div id="<?php echo esc_attr( $email_field->get_name() ); ?>-value">
										<?php
										if ( $email_field->get_value() ) {
											echo esc_html( $email_field->get_value() );
										} else {
											esc_html_e( 'Not specified', 'finder' );
										}
										?>
									</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link py-0 collapsed" href="#<?php echo esc_attr( $email_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $email_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
								<input class="form-control mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $email_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $email_field->get_name() ); ?>" value="<?php echo esc_attr( $email_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $email_field_args['placeholder'] ); ?>">
							</div>
						</div>

						<div class="border-bottom pb-3 mb-3">
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label fw-bold"><?php echo esc_html( $password_field->get_label() ); ?></label>
									<div>********</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link py-0 collapsed" href="#<?php echo esc_attr( $password_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $password_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
								<div class="password-toggle">
									<input class="form-control mt-3" type="password" name="<?php echo esc_attr( $password_field->get_name() ); ?>" data-bs-binded-element="#<?php echo esc_attr( $password_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" placeholder="<?php echo esc_attr( $password_field_args['placeholder'] ); ?>">
									<label class="password-toggle-btn" aria-label="<?php esc_attr_e('Show/hide password', 'finder'); ?>">
										<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
									</label>
								</div>
							</div>
						</div>

						<div>
							<div class="d-flex align-items-center justify-content-between">
								<div class="pe-2">
									<label class="form-label fw-bold"><?php echo esc_html( $current_password_field->get_label() ); ?></label>
									<div>********</div>
								</div>
								<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
									<a class="nav-link py-0 collapsed" href="#<?php echo esc_attr( $current_password_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
								</div>
							</div>
							<div class="collapse" id="<?php echo esc_attr( $current_password_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
							<div class="password-toggle">
								<input class="form-control mt-3" type="password" name="<?php echo esc_attr( $current_password_field->get_name() ); ?>" data-bs-binded-element="#<?php echo esc_attr( $current_password_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>"  placeholder="<?php echo esc_attr( $current_password_field_args['placeholder'] ); ?>">
								<label class="password-toggle-btn" aria-label="<?php esc_attr_e('Show/hide password', 'finder'); ?>">
										<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex align-items-center justify-content-between mt-4">
						<button type="submit" class="btn btn-primary rounded-pill px-3 px-sm-4"><?php esc_html_e( 'Save Changes', 'finder' ); ?></button>
						<a href="#user_delete_modal" class="btn btn-link btn-sm px-0" data-bs-toggle="modal">
							<i class="fi-trash me-2"></i>
							<span><?php esc_html_e( 'Delete Account', 'finder' ); ?></span>
						</a>
					</div>
				</div>
			</form>
			<?php finder_hivepress_user_delete_form(); ?>
				<?php

		} else {
			?>
			<div class="row pt-5">
				<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
					<div class="card card-body <?php echo esc_attr( $card_class ); ?> border-0 shadow-sm pb-1 me-lg-1">
						<?php
							finder_hivepress_sidebar_author_meta();
							finder_hivepress_sidebar_listing();
						?>
					</div>
				</aside>
				<div class="col-lg-8 col-md-7 mb-5">
					<div class="d-flex justify-content-between">
						<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Personal Info', 'finder' ); ?></h1>
					</div>
					<?php
					$user_update_form_args = array(
						'model'  => HivePress\Models\User::query()->get_by_id( get_current_user_id() ),
						'fields' => array(
							'first_name'       => array(
								'placeholder' => esc_html__( 'Enter your First Name', 'finder' ),
							),
							'last_name'        => array(
								'placeholder' => esc_html__( 'Enter your Last Name', 'finder' ),
							),
							'description'      => array(
								'label'       => esc_html__( 'Short bio', 'finder' ),
								'placeholder' => esc_html__( 'Enter your Bio', 'finder' ),
								'attributes'  => array(
									'rows' => 6,
								),
							),
							'email'            => array(
								'placeholder' => esc_html__( 'Enter your Email', 'finder' ),

							),
							'password'         => array(
								'placeholder' => esc_html__( 'Enter your Password', 'finder' ),

							),
							'current_password' => array(
								'placeholder' => esc_html__( 'Enter your Current Password', 'finder' ),

							),
						),
						'button' => array(
							'attributes' => array(
								'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-4' ),
							),
						),
					);

					$user_update_form = new User_Update( $user_update_form_args );

					$model = $user_update_form->get_model();

					$from_action = hivepress()->router->get_url(
						'user_update_action',
						array(
							'user_id' => $model->get_id(),
						)
					);

					$user_update_form_fields = $user_update_form->get_fields();

					$bio_field      = $user_update_form_fields['description'];
					$bio_field_args = $bio_field->get_args();

					$profile_image_field      = $user_update_form_fields['image'];
					$profile_image_field_args = $profile_image_field->get_args();

					$profile_image_field_formats = array();
					foreach ( $profile_image_field_args['formats'] as $format ) {
						$profile_image_field_formats[] = 'image/' . $format;
					}

					$fname_field      = $user_update_form_fields['first_name'];
					$fname_field_args = $fname_field->get_args();

					$lname_field      = $user_update_form_fields['last_name'];
					$lname_field_args = $lname_field->get_args();

					$email_field      = $user_update_form_fields['email'];
					$email_field_args = $email_field->get_args();

					$password_field      = $user_update_form_fields['password'];
					$password_field_args = $password_field->get_args();

					$current_password_field      = $user_update_form_fields['current_password'];
					$current_password_field_args = $current_password_field->get_args();

					$profile_completed_percent = 0;

					if ( $bio_field->get_value() ) {
						$profile_completed_percent = $profile_completed_percent + 20;
					}

					if ( $fname_field->get_value() ) {
						$profile_completed_percent = $profile_completed_percent + 20;
					}

					if ( $lname_field->get_value() ) {
						$profile_completed_percent = $profile_completed_percent + 20;
					}

					if ( $profile_completed_percent && $profile_completed_percent > 0 ) :
						?>
						<div class="mb-2 pt-1">
							<?php
							echo esc_html(
								/* translators: 1: percentage */
								sprintf( esc_html__( 'Your personal info is %s%% completed', 'finder' ), number_format_i18n( $profile_completed_percent ) )
							);
							?>
						</div>
						<div class="progress mb-4" style="height: .25rem;">
							<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_attr( $profile_completed_percent ); ?>%" aria-valuenow="<?php echo esc_attr( $profile_completed_percent ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					<?php endif; ?>

					<form data-model="user" data-id="<?php echo esc_attr( $model->get_id() ); ?>" data-message="<?php esc_attr_e( 'Changes have been saved.', 'finder' ); ?>" action="#" data-action="<?php echo esc_url( $from_action ); ?>" method="POST" data-component="form">
					
						<div class="hp-form__messages" data-component="messages"></div>

						<div class="row pt-2 account-profile">
						<?php if ( 'real-estate' === $account_style ) : ?>
							<div class="col-lg-9 col-sm-8 mb-4">
								<label class="form-label pt-2" for="<?php echo esc_attr( uniqid( $bio_field->get_name() ) ); ?>"><?php echo esc_html( $bio_field->get_label() ); ?></label>
								<textarea class="form-control" id="<?php echo esc_attr( uniqid( $bio_field->get_name() ) ); ?>" rows="<?php echo esc_attr( $bio_field_args['attributes']['rows'] ); ?>" name="<?php echo esc_attr( $bio_field->get_name() ); ?>" placeholder="<?php echo esc_attr( $bio_field_args['placeholder'] ); ?>" maxlength="<?php echo esc_attr( $bio_field_args['max_length'] ); ?>"><?php echo esc_html( $bio_field->get_value() ); ?></textarea>
							</div>
						<?php endif; ?>
							<div class="<?php echo esc_attr( 'car-finder' === $account_style ) ? 'col-lg-3 col-md-12 col-sm-4 mb-4 order-2' : 'col-lg-3 col-sm-4 mb-4'; ?>">
								<?php if ( 'car-finder' !== $account_style ) : ?>
									<div class="hp-row"><?php
										if( ! is_null( $profile_image_field->get_value() ) ) {
											$attachments = Models\Attachment::query()->filter(
												[
													'id__in' => (array) $profile_image_field->get_value(),
												]
											)->order( 'id__in' )
											->get();
											$attach = new Attachment_Upload();
											foreach ( $attachments as $attachment ) {
												print( $attach->render_attachment( $attachment ) );
											}
										}?></div>
									<label class="form-label pt-2" for="<?php echo esc_attr( uniqid( $profile_image_field->get_name() ) ); ?>"><?php echo esc_html( $profile_image_field->get_label() ); ?>
								<?php endif; ?>
								<?php if ( 'car-finder' === $account_style ) : ?>
									<div class="hp-row" style="height:160px">
									<?php
										if( ! is_null( $profile_image_field->get_value() ) ) {
											$attachments = Models\Attachment::query()->filter(
												[
													'id__in' => (array) $profile_image_field->get_value(),
												]
											)->order( 'id__in' )
											->get();
											$attach = new Attachment_Upload();
											foreach ( $attachments as $attachment ) {
												print( $attach->render_attachment( $attachment ) );
											}
										}?></div>
									<label class="form-label pt-2 border-light bg-faded-light text-light opacity-70" style="height:160px" for="<?php echo esc_attr( uniqid( $profile_image_field->get_name() ) ); ?>"><?php echo esc_html( $profile_image_field->get_label() ); ?>
								<?php endif; ?>
								<input type="file" name="image" id="<?php echo esc_attr( uniqid( $profile_image_field->get_name() ) ); ?>" data-component="file-upload" data-name="image" data-url="<?php echo esc_url( hivepress()->router->get_url( 'attachment_upload_action' ) ); ?>" accept="image/png, image/jpeg" class="hp-field hp-field--file">
								</label>
							</div>
							<?php if ( 'real-estate' === $account_style ) : ?>
						</div>
						<?php endif; ?>
						<?php if ( 'car-finder' === $account_style ) : ?>
						<div class="col-lg-9 col-md-12 col-sm-8 mb-2 mb-m-4">
						<?php endif; ?>
							<div class="border <?php echo esc_attr( 'car-finder' === $account_style ) ? 'border-light' : ''; ?> rounded-3 p-3 mb-4" id="user-info">
								<div class="border-bottom <?php echo esc_attr( 'car-finder' === $account_style ) ? 'border-light' : ''; ?> pb-3 mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="pe-2 <?php echo esc_attr( 'car-finder' === $account_style ) ? 'opacity-70' : ''; ?>">
											<label class="form-label <?php echo esc_attr( 'car-finder' === $account_style ) ? 'text-light' : ''; ?>  fw-bold"><?php echo esc_html( $fname_field->get_label() ); ?></label>
											<?php if ( 'car-finder' === $account_style ) : ?>
												<div class="text-light" id="<?php echo esc_attr( $fname_field->get_name() ); ?>-value">
													<?php
													if ( $fname_field->get_value() ) {
														echo esc_html( $fname_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php else : ?>
												<div id="<?php echo esc_attr( $fname_field->get_name() ); ?>-value">
													<?php
													if ( $fname_field->get_value() ) {
														echo esc_html( $fname_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php endif; ?>
										</div>
										<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
											<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $fname_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
										</div>
									</div>
									<div class="collapse" id="<?php echo esc_attr( $fname_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
										<input class="form-control <?php echo esc_attr( 'car-finder' === $account_style ) ? 'form-control-light' : ''; ?> mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $fname_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $fname_field->get_name() ); ?>" value="<?php echo esc_attr( $fname_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $fname_field_args['placeholder'] ); ?>">
									</div>
								</div>

								<div class="border-bottom <?php echo esc_attr( 'car-finder' === $account_style ) ? 'border-light' : ''; ?> pb-3 mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="pe-2 <?php echo esc_attr( 'car-finder' === $account_style ) ? 'opacity-70' : ''; ?>">
											<label class="form-label <?php echo esc_attr( 'car-finder' === $account_style ) ? 'text-light' : ''; ?>  fw-bold"><?php echo esc_html( $lname_field->get_label() ); ?></label>
											<?php if ( 'car-finder' === $account_style ) : ?>
												<div class="text-light" id="<?php echo esc_attr( $lname_field->get_name() ); ?>-value">
													<?php
													if ( $lname_field->get_value() ) {
														echo esc_html( $lname_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php else : ?>
												<div id="<?php echo esc_attr( $lname_field->get_name() ); ?>-value">
													<?php
													if ( $lname_field->get_value() ) {
														echo esc_html( $lname_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php endif; ?>
										</div>
										<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
											<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $lname_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
										</div>
									</div>
									<div class="collapse" id="<?php echo esc_attr( $lname_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
										<input class="form-control <?php echo esc_attr( 'car-finder' === $account_style ) ? 'form-control-light' : ''; ?> mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $lname_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $lname_field->get_name() ); ?>" value="<?php echo esc_attr( $lname_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $lname_field_args['placeholder'] ); ?>">
									</div>
								</div>
								<?php if ( 'car-finder' === $account_style ) : ?>
									<div class="border-bottom border-light pb-3 mb-3">
										<div class="d-flex align-items-center justify-content-between">
											<div class="pe-2 opacity-70">
												<label class="form-label text-light fw-bold"><?php echo esc_html( $bio_field->get_label() ); ?></label>
												<div class="text-light" id="<?php echo esc_attr( $bio_field->get_name() ); ?>-value">
													<?php
													if ( $bio_field->get_value() ) {
														echo esc_html( $bio_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											</div>
											<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
												<a class="nav-link nav-link-light py-0 collapsed" href="#<?php echo esc_attr( $bio_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
											</div>
										</div>
										<div class="collapse" id="<?php echo esc_attr( $bio_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
											<input class="form-control form-control-light mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $bio_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $bio_field->get_name() ); ?>" value="<?php echo esc_attr( $bio_field->get_value() ); ?>" rows="<?php echo esc_attr( $bio_field_args['attributes']['rows'] ); ?>" placeholder="<?php echo esc_attr( $bio_field_args['placeholder'] ); ?>">
										</div>
									</div>
								<?php endif; ?>
								<div class="border-bottom <?php echo esc_attr( 'car-finder' === $account_style ) ? 'border-light' : ''; ?> pb-3 mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="pe-2 <?php echo esc_attr( 'car-finder' === $account_style ) ? 'opacity-70' : ''; ?>">
											<label class="form-label <?php echo esc_attr( 'car-finder' === $account_style ) ? 'text-light' : ''; ?> fw-bold"><?php echo esc_html( $email_field->get_label() ); ?></label>
											<?php if ( 'car-finder' === $account_style ) : ?>
												<div class="text-light" id="<?php echo esc_attr( $email_field->get_name() ); ?>-value">
													<?php
													if ( $email_field->get_value() ) {
														echo esc_html( $email_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php else : ?>
												<div id="<?php echo esc_attr( $email_field->get_name() ); ?>-value">
													<?php
													if ( $email_field->get_value() ) {
														echo esc_html( $email_field->get_value() );
													} else {
														esc_html_e( 'Not specified', 'finder' );
													}
													?>
												</div>
											<?php endif; ?>
										</div>
										<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
											<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $email_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
										</div>
									</div>
									<div class="collapse" id="<?php echo esc_attr( $email_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
										<input class="form-control <?php echo esc_attr( 'car-finder' === $account_style ) ? 'form-control-light' : ''; ?> mt-3" type="text" data-bs-binded-element="#<?php echo esc_attr( $email_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" name="<?php echo esc_attr( $email_field->get_name() ); ?>" value="<?php echo esc_attr( $email_field->get_value() ); ?>" placeholder="<?php echo esc_attr( $email_field_args['placeholder'] ); ?>">
									</div>
								</div>

								<div class="border-bottom <?php echo esc_attr( 'car-finder' === $account_style ) ? 'border-light' : ''; ?> pb-3 mb-3">
									<div class="d-flex align-items-center justify-content-between">
										<div class="pe-2 <?php echo esc_attr( 'car-finder' === $account_style ) ? 'opacity-70' : ''; ?>">
											<label class="form-label <?php echo esc_attr( 'car-finder' === $account_style ) ? 'text-light' : ''; ?> fw-bold"><?php echo esc_html( $password_field->get_label() ); ?></label>
											<div>********</div>
										</div>
										<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
											<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $password_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
										</div>
									</div>
									<div class="collapse" id="<?php echo esc_attr( $password_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
										<div class="password-toggle">
											<input class="form-control <?php echo esc_attr( 'car-finder' === $account_style ) ? 'form-control-light' : ''; ?> mt-3" type="password" name="<?php echo esc_attr( $password_field->get_name() ); ?>" data-bs-binded-element="#<?php echo esc_attr( $password_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>" placeholder="<?php echo esc_attr( $password_field_args['placeholder'] ); ?>">
											<label class="password-toggle-btn" aria-label="<?php esc_attr_e('Show/hide password', 'finder'); ?>">
												<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
											</label>
										</div>
									</div>
								</div>

								<div>
									<div class="d-flex align-items-center justify-content-between">
										<div class="pe-2 <?php echo esc_attr( 'car-finder' === $account_style ) ? 'opacity-70' : ''; ?>">
											<label class="form-label <?php echo esc_attr( 'car-finder' === $account_style ) ? 'text-light' : ''; ?> fw-bold"><?php echo esc_html( $current_password_field->get_label() ); ?></label>
											<div>********</div>
										</div>
										<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
											<a class="nav-link <?php echo esc_attr( 'car-finder' === $account_style ) ? 'nav-link-light' : ''; ?> py-0 collapsed" href="#<?php echo esc_attr( $current_password_field->get_name() ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="false"><i class="fi-edit"></i></a>
										</div>
									</div>
									<div class="collapse" id="<?php echo esc_attr( $current_password_field->get_name() ); ?>-collapse" data-bs-parent="#user-info">
										<div class="password-toggle">
											<input class="form-control <?php echo esc_attr( 'car-finder' === $account_style ) ? 'form-control-light' : ''; ?> mt-3" type="password" name="<?php echo esc_attr( $current_password_field->get_name() ); ?>" data-bs-binded-element="#<?php echo esc_attr( $current_password_field->get_name() ); ?>-value" data-bs-unset-value="<?php esc_attr_e( 'Not specified', 'finder' ); ?>"  placeholder="<?php echo esc_attr( $current_password_field_args['placeholder'] ); ?>">
											<label class="password-toggle-btn" aria-label="<?php esc_attr_e('Show/hide password', 'finder'); ?>">
												<input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						<?php if ( 'car-finder' === $account_style ) : ?>
						</div>
					</div>
						<div class="row">
							<div class="col-lg-9">
						<?php endif; ?>
							<div class="d-flex align-items-center justify-content-between <?php echo esc_attr( 'car-finder' === $account_style ) ? '' : 'mt-4'; ?> pb-1">
								<button type="submit" class="btn btn-primary px-3 px-sm-4"><?php esc_html_e( 'Save Changes', 'finder' ); ?></button>
								<a href="#user_delete_modal" class="btn btn-link btn-sm <?php echo esc_attr( 'car-finder' === $account_style ) ? 'btn-light' : ''; ?> px-0" data-bs-toggle="modal">
									<i class="fi-trash me-2"></i>
									<span><?php esc_html_e( 'Delete Account', 'finder' ); ?></span>
								</a>
							</div>
						<?php if ( 'car-finder' === $account_style ) : ?>
							</div>
						</div>
						<?php endif; ?>
					</form>
					<?php finder_hivepress_user_delete_form(); ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>


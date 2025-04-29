<?php
/**
 * Content for job submission (`[submit_job_form]`) shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-submit.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     finder
 * @version     1.34.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $job_manager;
$user = wp_get_current_user();

$breadcrumb_args = array(
	'style' => 'light',
);

$sticky_header = finder_is_sticky_header();
$wrap_class    = 'mt-4 mb-md-4';

if ( $sticky_header ) {
	$wrap_class = 'mt-5 mb-md-4 py-5';
}

?>
<div class="position-absolute top-0 start-0 w-100 bg-dark" style="height: 398px;z-index: -1;"></div>
<div class="container content-overlay  not-prose <?php echo esc_attr( $wrap_class ); ?>">
<?php finder_breadcrumb( $breadcrumb_args ); ?>
	<div class="bg-light shadow-sm rounded-3 p-4 p-md-5 mb-2">
	<div class="mb-3">
		<?php if ( apply_filters( 'submit_job_form_show_signin', true ) ) : ?>

			<?php get_job_manager_template( 'account-signin.php' ); ?>

		<?php endif; ?>
	</div>
	<?php if ( job_manager_user_can_post_job() || job_manager_user_can_edit_job( $job_id ) ) : ?>
		<div class="d-flex align-items-start justify-content-between pb-4 mb-2 border-bottom">
			<div class="d-flex align-items-start">
				<div class="position-relative flex-shrink-0">
					<?php echo get_avatar( $user->ID, 100, '', $user->display_name, array( 'class' => 'rounded-circle' ) ); ?>
				</div>
				<div class="ps-3 ps-sm-4">
					<h3 class="h5"><?php echo esc_html( $user->display_name ); ?></h3>
					<ul class="list-unstyled fs-sm mb-0">
						<li class="d-flex text-nav text-break"><i class="fi-mail opacity-60 mt-1 me-2"></i><?php echo esc_html( $user->user_email ); ?></li>
					</ul>
				</div>
			</div>
			<a class="nav-link p-0 d-none d-md-block" href="<?php echo esc_url( apply_filters( 'submit_job_form_logout_url', wp_logout_url( get_permalink() ) ) ); ?>"><i class="fi-logout mt-n1 me-2"></i><?php esc_html_e( 'Sign out', 'finder' ); ?></a>
		</div>
		<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-job-form" class="job-manager-form" enctype="multipart/form-data">
			<?php
			if ( isset( $resume_edit ) && $resume_edit ) {
				/* translators: %s: edit job */
				printf( '<p><strong>' . esc_html__( 'You are editing an existing job. %s', 'finder' ) . '</strong></p>', '<a href="?job_manager_form=submit-job&new=1&key=' . esc_attr( $resume_edit ) . '">' . esc_html__( 'Create A New Job', 'finder' ) . '</a>' );
			}
			?>
			<?php do_action( 'submit_job_form_start' ); ?>
				<!-- Job Information Fields -->
				<?php do_action( 'submit_job_form_job_fields_start' ); ?>
				<div class="row pt-4 mt-3">
					<div class="col-lg-3">
						<h2 class="h4"><?php esc_html_e( 'Job Details', 'finder' ); ?></h2>
					</div>
					<div class="col-lg-9">
						<div class="border rounded-3 p-3" id="auth-info">
							<?php foreach ( $job_fields as $key => $field ) : ?>
								<?php if ( 'text' === $field['type'] ) : ?>
									<div class="border-bottom pb-3 mb-3">
										<div class="d-flex align-items-center justify-content-between">
											<div class="pe-2">
												<label class="form-label fw-bold"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
												<div id="<?php echo esc_attr( $key ); ?>-bind"><?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?></div>
											</div>
											<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit" aria-label="<?php esc_attr_e( 'Edit','finder'); ?>"><a class="nav-link py-0" href="#<?php echo esc_attr( $key ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="true"><i class="fi-edit"></i></a></div>
										</div>
										<div class="collapse " id="<?php echo esc_attr( $key ); ?>-collapse" data-bs-parent="#<?php echo esc_attr( $key ); ?>" style="">
											<input type="text" class="form-control mt-3 input-text" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
											<?php
											if ( isset( $field['autocomplete'] ) && false === $field['autocomplete'] ) {
												echo ' autocomplete="off"'; }
											?>
											id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>" value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>" maxlength="<?php echo esc_attr( ! empty( $field['maxlength'] ) ? $field['maxlength'] : '' ); ?>" 
											<?php
											if ( ! empty( $field['required'] ) ) {
												echo 'required'; }
											?>
											data-bs-binded-element="#<?php echo esc_attr( $key ); ?>-bind" data-bs-unset-value="Not specified">
											<?php if ( ! empty( $field['description'] ) ) : ?>
												<small class="description"><?php echo wp_kses_post( $field['description'] ); ?></small>
											<?php endif; ?>
										</div>
									</div>
								<?php elseif ( 'term-multiselect' === $field['type'] || 'term-select' === $field['type'] ) : ?>
									<?php
										$job_listing_categories = get_job_listing_categories();
										$job_listing_types      = get_job_listing_types();

										$is_type_enable = finder_wpjm_enable_job_types();
										$has_types      = $is_type_enable && ! empty( $job_listing_types );

										$is_category_enable = finder_wpjm_enable_category();
										$has_categories     = $is_category_enable && ! empty( $job_listing_categories );
									?>
										<div class="border-bottom pb-3 mb-3">
											<div class="d-flex align-items-center justify-content-between">
												<div class="pe-2">
												<label class="form-label fw-bold"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
													<div id="<?php echo esc_attr( $key ); ?>-value"></div>
												</div>
												<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit" aria-label="<?php esc_attr_e( 'Edit','finder'); ?>">
													<a class="nav-link py-0" href="#<?php echo esc_attr( $key ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="true"><i class="fi-edit"></i></a>
												</div>
											</div>
											<?php if ( $has_categories && 'job_category' === $key && 'term-multiselect' === $field['type'] ) : ?>
												<div class="collapse " id="<?php echo esc_attr( $key ); ?>-collapse" data-bs-parent="#<?php echo esc_attr( $key ); ?>" style="">
												<?php
													wp_enqueue_script( 'wp-job-manager-multiselect' );
												?>
													<select multiple="multiple" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>[]" id="<?php echo esc_attr( $key ); ?>" class="form-select mt-3 job-manager-multiselect" 
																								 <?php
																									if ( ! empty( $field['required'] ) ) {
																										echo 'required';}
																									?>
													 data-no_results_text="<?php esc_attr_e( 'No results match', 'finder' ); ?>" data-multiple_text="<?php esc_attr_e( 'Select Some Options', 'finder' ); ?>">
														<?php
														if ( ! empty( $field['required'] ) ) {
															echo 'required'; }
														?>
														<?php foreach ( $job_listing_categories as $key => $job_cat ) : ?>
															<option value="<?php echo esc_attr( $job_cat->term_id ); ?>" 
																					  <?php
																						if ( ! empty( $field['value'] ) && is_array( $field['value'] ) ) {
																							selected( in_array( $job_cat->term_id, $field['value'] ), true );}
																						?>
															><?php echo esc_html( $job_cat->name ); ?></option>
														<?php endforeach; ?>
													</select>
													<?php
													if ( ! empty( $field['description'] ) ) :
														?>
														<small class="description"><?php echo wp_kses_post( $field['description'] ); ?></small><?php endif; ?>
												</div>
											<?php endif; ?>
											<?php if ( $has_types && 'job_type' === $key ) : ?>
												<div class="collapse " id="<?php echo esc_attr( $key ); ?>-collapse" data-bs-parent="#<?php echo esc_attr( $key ); ?>" style="">
													<select name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>" id="<?php echo esc_attr( $key ); ?>" 
														<?php
														if ( ! empty( $field['required'] ) ) {
															echo 'required'; }
														?>
														class="form-select mt-3" data-bs-binded-element="#<?php echo esc_attr( $key ); ?>-value" data-bs-unset-value="Not specified">
															<?php foreach ( $job_listing_types as $test ) : ?>
																<option value="<?php echo isset( $test->term_id ) ? esc_attr( $test->term_id ) : ''; ?>"><?php echo esc_html( $test->name ); ?></option>
															<?php endforeach; ?>
													</select>
												</div>
											<?php endif; ?>
										</div>									
									<?php
								elseif ( 'checkbox' === $field['type'] ) :
									?>
									<div class="border-bottom pb-3 mb-3">
											<div class="d-flex align-items-center justify-content-between">
												<div class="pe-2">
												<label class="form-label fw-bold"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
													<div id="<?php echo esc_attr( $key ); ?>-value"></div>
												</div>
												<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit" aria-label="<?php esc_attr_e( 'Edit','finder'); ?>">
													<a class="nav-link py-0" href="#<?php echo esc_attr( $key ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="true"><i class="fi-edit"></i></a>
												</div>
											</div>
											<div class="collapse " id="<?php echo esc_attr( $key ); ?>-collapse" data-bs-parent="#<?php echo esc_attr( $key ); ?>" style="">
												<div class="form-check">
													<input class="form-check-input" id="<?php echo esc_attr( $key ); ?>" type="radio" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>" data-bs-binded-element="#<?php echo esc_attr( $key ); ?>-value" data-bs-unset-value="Not specified">
													<label class="form-check-label" for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ); ?></label>
												</div>
											</div>
										</div>
									<?php
								else :
									?>
										<fieldset class="fieldset-<?php echo esc_attr( $key ); ?> fieldset-type-<?php echo esc_attr( $field['type'] ); ?>">
											<label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
											<div class="field <?php echo esc_attr( $field['required'] ? 'required-field' : '' ); ?>">
												<?php
												get_job_manager_template(
													'form-fields/' . $field['type'] . '-field.php',
													array(
														'key' => $key,
														'field' => $field,
													)
												);
												?>
											</div>
										</fieldset>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<?php do_action( 'submit_job_form_job_fields_end' ); ?>

				<!-- Company Information Fields -->
				<?php if ( $company_fields ) : ?>
					<div class="row pt-4 mt-3">
						<div class="col-lg-3">
							<h2 class="h4"><?php esc_html_e( 'Company Details', 'finder' ); ?></h2>
						</div>
						<div class="col-lg-9">
							<div class="border rounded-3 p-3" id="personal-details">
								<?php do_action( 'submit_job_form_company_fields_start' ); ?>

								<?php foreach ( $company_fields as $key => $field ) : ?>
									<?php if ( 'text' === $field['type'] ) : ?>
										<div class="border-bottom pb-3 mb-3">
											<div class="d-flex align-items-center justify-content-between">
												<div class="pe-2">
													<label class="form-label fw-bold"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
													<div id="<?php echo esc_attr( $key ); ?>-bind"><?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?></div>
												</div>
												<div class="me-n3" data-bs-toggle="tooltip" data-bs-original-title="Edit" aria-label="<?php esc_attr_e( 'Edit','finder'); ?>"><a class="nav-link py-0" href="#<?php echo esc_attr( $key ); ?>-collapse" data-bs-toggle="collapse" aria-expanded="true"><i class="fi-edit"></i></a></div>
											</div>
											<div class="collapse " id="<?php echo esc_attr( $key ); ?>-collapse" data-bs-parent="#auth-info" style="">
												<input type="text" class="form-control mt-3 input-text" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"
												<?php
												if ( isset( $field['autocomplete'] ) && false === $field['autocomplete'] ) {
													echo ' autocomplete="off"'; }
												?>
												id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>" value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>" maxlength="<?php echo esc_attr( ! empty( $field['maxlength'] ) ? $field['maxlength'] : '' ); ?>" 
												<?php
												if ( ! empty( $field['required'] ) ) {
													echo 'required'; }
												?>
												data-bs-binded-element="#<?php echo esc_attr( $key ); ?>-bind" data-bs-unset-value="Not specified">
												<?php if ( ! empty( $field['description'] ) ) : ?>
													<small class="description"><?php echo wp_kses_post( $field['description'] ); ?></small>
												<?php endif; ?>
											</div>
										</div>
									<?php elseif ( 'file' === $field['type'] ) : ?>
										<div class="pb-3">
											<div class="pe-2">
												<label class="form-label fw-bold"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
											</div>
											<?php
											$classes            = array( 'input-text', 'form-control' );
											$allowed_mime_types = array_keys( ! empty( $field['allowed_mime_types'] ) ? $field['allowed_mime_types'] : get_allowed_mime_types() );
											$field_name         = isset( $field['name'] ) ? $field['name'] : $key;
											$field_name        .= ! empty( $field['multiple'] ) ? '[]' : '';
											$file_limit         = false;
											$value              = isset( $field['value'] ) ? $field['value'] : $key;


											if ( ! empty( $field['multiple'] ) && ! empty( $field['file_limit'] ) ) {
												$file_limit = $field['file_limit'];
											}

											if ( ! empty( $field['ajax'] ) && job_manager_user_can_upload_file_via_ajax() ) {
												wp_enqueue_script( 'wp-job-manager-ajax-file-upload' );
												$classes[] = 'wp-job-manager-file-upload';
											}
											?>
											<div class="job-manager-uploaded-files">
												<div class="job-manager-uploaded-file mb-3">
													<?php
													if ( is_numeric( $value ) ) {
														$image_src = wp_get_attachment_image_src( absint( $value ) );
														$image_src = $image_src ? $image_src[0] : '';
													} else {
														$image_src = $value;
													}
													$extension = ! empty( $extension ) ? $extension : substr( strrchr( $image_src, '.' ), 1 );
													if ( 'image' === wp_ext2type( $extension ) ) :
														?>
														<span class="d-inline-block job-manager-uploaded-file-preview"><img class="rounded" src="<?php echo esc_url( $image_src ); ?>"> <a class="end-0 fs-4 job-manager-remove-uploaded-file me-1 mt-1 top-0" href="#"><i class="fi-x-circle"></i></a></span>
													<?php else : ?>
														<span class="job-manager-uploaded-file-name"><code><?php echo esc_html( basename( $image_src ) ); ?></code> <a class="job-manager-remove-uploaded-file" href="#"><i class="fi-x-circle"></i></a></span>
													<?php endif; ?>

													<input type="hidden" class="input-text" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>" value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>">
												</div>
											</div>
											<input
												type="file"
												class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
												data-file_types="<?php echo esc_attr( implode( '|', $allowed_mime_types ) ); ?>"
												<?php
												if ( ! empty( $field['multiple'] ) ) {
													echo 'multiple';}
												?>
												<?php
												if ( $file_limit ) {
													echo ' data-file_limit="' . absint( $file_limit ) . '"';}
												?>
												<?php
												if ( ! empty( $field['file_limit_message'] ) ) {
													echo ' data-file_limit_message="' . esc_attr( $field['file_limit_message'] ) . '"';}
												?>
												name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>
																 <?php
																	if ( ! empty( $field['multiple'] ) ) {
																		echo '[]';}
																	?>
												"
												id="<?php echo esc_attr( $key ); ?>"
												placeholder="<?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?>"
											>
											<small class="description">
												<?php if ( ! empty( $field['description'] ) ) : ?>
													<?php echo wp_kses_post( $field['description'] ); ?>
												<?php else : ?>
													<?php
													/* translators: 1: number of comments, 2: post title */
													printf( esc_html__( 'Maximum file size: %s.', 'finder' ), wp_kses_post( size_format( wp_max_upload_size() ) ) );
													?>
												<?php endif; ?>
											</small>
										</div>
									<?php else : ?>
										<fieldset class="fieldset-<?php echo esc_attr( $key ); ?> fieldset-type-<?php echo esc_attr( $field['type'] ); ?>">
											<label class="form-label fw-bold" for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'finder' ) . '</small>', $field ) ); ?></label>
											<div class="field <?php echo esc_attr( $field['required'] ? 'required-field' : '' ); ?>">
												<?php
												get_job_manager_template(
													'form-fields/' . $field['type'] . '-field.php',
													array(
														'key' => $key,
														'field' => $field,
													)
												);
												?>
											</div>
										</fieldset>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<?php do_action( 'submit_job_form_company_fields_end' ); ?>
				<?php endif; ?>

				<div class="row pt-4">
					<div class="col-lg-9 offset-lg-3">
						<?php do_action( 'submit_job_form_end' ); ?>
					</div>
				</div>
				<div class="row pt-4 mt-2">
					<div class="col-lg-9 offset-lg-3">
						<div class="d-flex align-items-center justify-content-between">
							<p>
								<input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form ); ?>">
								<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>">
								<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>">
								<input type="submit" name="submit_job" class="btn btn-primary rounded-pill px-3 px-sm-4" value="<?php echo esc_attr( $submit_button_text ); ?>">
								<?php
								if ( isset( $can_continue_later ) && $can_continue_later ) {
									echo '<input type="submit" name="save_draft" class="btn btn-outline-primary rounded-pill px-3 px-sm-4 save_draft" value="' . esc_attr__( 'Save Draft', 'finder' ) . '" formnovalidate>';
								}
								?>
								<span class="spinner" style="background-image: url(<?php echo esc_url( includes_url( 'images/spinner.gif' ) ); ?>);"></span>
							</p>
						</div>
					</div>
				</div>
			</form>
		</div>
			<?php else : ?>
				<?php do_action( 'submit_job_form_disabled' ); ?>
		
	<?php endif; ?>
</div>

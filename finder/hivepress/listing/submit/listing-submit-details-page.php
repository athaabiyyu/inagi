<?php
/**
 * The Template for displaying listing submit details page
 *
 * @package Finder
 */

use HivePress\Forms\Listing_Submit;
use HivePress\Fields\Attachment_Upload;
use HivePress\Models;

$add_property_listing_args = apply_filters(
	'finder_add_property_listing_args',
	array(
		'model'  => $listing,
		'button' => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-4' ),
			),
		),
	)
);

$add_property_listing = new Listing_Submit( $add_property_listing_args );

$style = finder_hivepress_get_listing_single_style();

switch ( $style ) {
	case 'real-estate':
		$property_title     = 'Add Property';
		$details_text       = 'Property Details';
		$stitle_class       = 'h2 mb-0';
		$title_class        = 'h4 mb-4';
		$lable_class        = 'form-label d-block fw-bold mb-2 pb-1';
		$section_class      = 'card card-body border-0 shadow-sm p-4 mb-4 ';
		$body_class         = '';
		$button_class       = '';
		$form_select        = 'form-select ';
		$form_control_class = 'form-control';
		$date_time_class    = 'date-picker rounded pe-5';
		$form_check_class   = '';
		$button_out_line    = ' btn-outline-dark ';
		break;
	case 'city-guide':
		$property_title     = 'Add Business';
		$details_text       = 'Business Details';
		$stitle_class       = 'h2 mb-0';
		$title_class        = 'h4 mb-4';
		$lable_class        = 'form-label d-block fw-bold mb-2 pb-1';
		$section_class      = 'card card-body border-0 shadow-sm p-4 mb-4';
		$body_class         = ' bg-secondary';
		$button_class       = ' rounded-pill';
		$form_select        = 'form-select ';
		$form_control_class = 'form-control';
		$date_time_class    = 'date-picker rounded pe-5';
		$form_check_class   = '';
		$button_out_line    = ' btn-outline-dark ';
		break;
	case 'car-finder':
		$property_title     = 'Add Car';
		$details_text       = 'Car Details';
		$stitle_class       = 'h2 text-white mb-0';
		$title_class        = 'h4 mb-4 text-light ';
		$lable_class        = 'form-label d-block fw-bold mb-2 pb-1 text-light';
		$section_class      = 'card card-light card-body border-0 shadow-sm p-4 mb-4';
		$body_class         = ' bg-dark';
		$button_class       = '';
		$form_select        = 'form-select form-select-light';
		$form_control_class = 'form-control form-control-light';
		$date_time_class    = 'date-picker rounded pe-5 form-control-light';
		$form_check_class   = ' form-check-light';
		$button_out_line    = ' btn-outline-light ';
		break;
}
$model = $add_property_listing->get_model();

$from_action = hivepress()->router->get_url(
	'listing_update_action',
	array(
		'listing_id' => $model->get_id(),
	)
);

$add_property_listing_fields = $add_property_listing->get_fields();

$sticky_header = finder_is_sticky_header();

$container_class = 'container mt-5 py-5';
if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4';
}

?><div class="finder-listing-single-add-property-wrap">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<h1 class="<?php echo esc_attr( $stitle_class ); ?>"><?php echo esc_html( $property_title ); ?></h1>
					<?php if ( $listing->get_categories__id() ) : ?>
						<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_submit_category_page' ) ); ?>" class="btn <?php echo esc_attr( $button_out_line ); ?> btn-xs hp-form__action hp-form__action--listing-category-change hp-link">
							<i class="hp-icon fas fa-arrow-left"></i>
							<span class="ms-1"><?php esc_html_e( 'Change Category', 'finder' ); ?></span>
						</a>
					<?php endif; ?>
				</div>
				<section class="<?php echo esc_attr( $section_class ); ?>">
					<h2 class="<?php echo esc_attr( $title_class ); ?>">
						<i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>
						<?php echo esc_html( $details_text ); ?>
					</h2>
					<form data-model="listing" data-id="<?php echo esc_attr( $model->get_id() ); ?>" action="#" data-action="<?php echo esc_url( $from_action ); ?>" method="POST" data-redirect="true" data-component="form">

						<div class="hp-form__messages" data-component="messages"></div>

						<?php
						foreach ( $add_property_listing_fields as $key => $field ) {
							switch ( $field->get_display_type() ) {
								case 'attachment_upload':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( 'hp_images' . '_' );
									$diff_style = finder_hivepress_get_listing_single_style();
									$form_control_class =  $form_control_class . ' mt-2';
									$value       = $field->get_value();
									$multiple    = $field->get_args()['multiple'];

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_class,
										'type'  => 'file',
										'data-component' => 'file-upload',
										'name'  => 'hp_images',
										'data-url' => hivepress()->router->get_url( 'attachment_upload_action' ),
										'data-name' => 'images',
									);
									$hp_attr = array(
										'class' => 'hp-row d-flex flex-wrap mb-3'
									);
									if ( $multiple ) {
										$attr['multiple'] = 'multiple';
									}
									
									if ( is_array( $value ) && sizeof( $value ) > 1 ) {
										$hp_attr['data-component'] = 'sortable';
									}
									?><div class="mb-3">
										<div <?php finder_render_attr( 'listing_submit_attachment_field_hp_row' . $key, $hp_attr ); ?>>
										<?php if( ! is_null( $value ) ) {
											$attachments = Models\Attachment::query()->filter(
												[
													'id__in' => (array) $value,
												]
											)->order( 'id__in' )
											->get();
											$attach = new Attachment_Upload();
											foreach ( $attachments as $attachment ) {
												print( $attach->render_attachment( $attachment ) );
											}
										}
										?>
										</div>
											<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?>
											<input <?php finder_render_attr( 'listing_submit_attachment_field_' . $key, $attr ); ?>></label>
										</div><?php
									break;
								case 'text':
								// case 'location':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$max_length  = $field_args['max_length'];
									$is_required = $field->is_required();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_class,
										'type'  => $field->get_display_type(),
										'name'  => $field->get_name(),
									);

									if ( $max_length ) {
										$attr['maxlength'] = $max_length;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}

									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
													<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input <?php finder_render_attr( 'listing_submit_text_field_' . $key, $attr ); ?>>
										</div>
										<?php
									break;

								case 'location':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$max_length  = $field_args['max_length'];
									$is_required = $field->is_required();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_class,
										'type'  => 'text',
										'name'  => $field->get_name(),
									);

									if ( $max_length ) {
										$attr['maxlength'] = $max_length;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}

									$countries = array_filter( (array) get_option( 'hp_geolocation_countries' ) );

									$countries = wp_json_encode($countries);

									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
													<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input type="hidden" name="post_type" value="hp_listing">
											<input type="hidden" name="latitude" value="" data-coordinate="lat">
											<input type="hidden" name="longitude" value="" data-coordinate="lng">
											<div data-countries="<?php echo esc_attr( $countries ); ?>" data-component="location">
												<input <?php finder_render_attr( 'listing_submit_location_field_' . $key, $attr ); ?>>
											</div>
										</div>
										<?php

									break;

								case 'textarea':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$max_length  = $field_args['max_length'];
									$is_required = $field->is_required();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_class,
										'type'  => $field->get_display_type(),
										'name'  => $field->get_name(),
										'rows'  => 5,
									);

									if ( $max_length ) {
										$attr['maxlength'] = $max_length;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>

											<textarea <?php finder_render_attr( 'listing_submit_textarea_field_' . $key, $attr ); ?>></textarea>
										</div>
										<?php
									break;

								case 'select':
									$cat_values  = ( get_the_terms( $listing->get_id(), 'hp_listing_category' ) );
									$cat_value   = ! empty( $cat_value ) ? array_pop($cat_values) : '';
									$cat_value   = ! empty( $cat_value ) ? $cat_value->term_id : 0 ;
									$label       = $field->get_args()['label'];
									$placeholder = isset( $field->get_args()['placeholder'] ) ? $field->get_args()['placeholder'] : 'Select' ;
									$multiple    = $field->get_args()['multiple'];
									$options     = $field->get_args()['options'];
									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_select,
										'type'        => $field->get_display_type(),
										'name'        => $field->get_name(),
										'placeholder' => $placeholder,
									);
									if ( isset( $multiple ) && $multiple ) {
										$attr['name']    .= '[]';
										$attr['multiple'] = true;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
									<div  class="mb-3">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?> 
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
										<?php endif; ?>
										</label>
										<select <?php finder_render_attr( 'listing_submit_select_field_' . $key, $attr ); ?>>
										<?php foreach ( $options as $key => $option ) : ?>
												<?php
												$options_attr = ( (int)$cat_value === (int) $key ) && 'Category' === $label ?  array( 'value' => $key, 'selected' => true ) : array( 'value' => $key );
												$select_options_attr = $options_attr;
													?>
											<option <?php finder_render_attr( 'listing_submit_select_field_' . $key, $select_options_attr ); ?>><?php echo esc_html( $option['label'] ); ?></option>
										<?php endforeach; ?>
										</select>
									</div>
										<?php
									break;

								case 'checkbox':
									$caption     = $field->get_args()['label'];
									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$check_value = true;
									$value       = '';

									if ( $is_required ) {
										$attr['required'] = true;
									}

									?>
									<div  class="mb-3">
										<div class="form-check <?php echo esc_attr( $form_check_class ); ?> mb-3">
											<input class="form-check-input" id="<?php echo esc_attr( $unique_id ); ?>" type="checkbox" name="<?php echo esc_attr( $field->get_name() ); ?>" <?php checked( $value, $check_value ); ?>>
											<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>">
													<?php echo wp_kses_post( $caption ); ?>
											</label>
										</div>
									</div>
									<?php
									break;
								case 'checkboxes':
									$label     = $field->get_args()['label'];
									$options   = $field->get_args()['options'];
									$max_value = $field->get_args()['max_values'];
									$selected_values = $field->get_value();
									?>
										<div class="mb-4">
											<label class="<?php echo esc_attr( $lable_class ); ?>">
											<?php echo esc_html( $label ); ?>
											</label>
											<div class="row">
												<div class="col-sm-4">
												<?php foreach ( $options as $key => $value ) : ?>
													<?php
														$unique_id = uniqid( $field->get_name() . '_' );
														$attr = array(
															'id'    => $unique_id,
															'class' => 'form-check-input',
															'type'  => 'checkbox',
															'name'  => $field->get_name() . '[]',
															'value' => $key,
														);

														if ( ! empty( $selected_values ) && in_array($key, $selected_values)) {
															$attr['checked'] = 'checked';
														}
														?>
														<div class="form-check<?php echo esc_attr( $form_check_class ); ?>">
															<input <?php finder_render_attr( 'listing_submit_checkboxes_field_' . $key, $attr ); ?>>
															<label class="form-check-label" for="<?php echo esc_attr( $unique_id ); ?>">
																<?php echo esc_html( $value['label'] ); ?> 
															</label>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
										<?php
									break;
								case 'radio':
									$label   = $field->get_args()['label'];
									$options = $field->get_args()['options'];
									$radio_selected_values = $field->get_value();
									?>
									<div class="mb-4">
										<label class="<?php echo esc_attr( $lable_class ); ?>">
											<?php echo esc_html( $label ); ?>
										</label>
										<?php foreach ( $options as $key => $value ) : ?>
											<?php
												$unique_id = uniqid( $field->get_name() . '_' );

												$attr = array(
													'id'   => $unique_id,
													'class' => 'form-check-input',
													'type' => 'radio',
													'name' => $field->get_name(),
													'value' => $key,
												);
												if ( ! empty( $radio_selected_values ) && ($key === $radio_selected_values)) {
													$attr['checked'] = 'checked';
												}
												?>
											<div class="form-check<?php echo esc_attr( $form_check_class ); ?>">
												<input <?php finder_render_attr( 'listing_submit_radio_field_' . $key, $attr ); ?>>
												<label class="form-check-label" for="<?php echo esc_attr( $unique_id ); ?>">
													<?php echo esc_html( $value['label'] ); ?> 
												</label>
											</div>
										<?php endforeach; ?>
									</div>
									<?php
									break;
								case 'number':
									$label = $field->get_args()['label'];

									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_class,
										'type'        => 'number',
										'name'        => $field->get_name(),
									);

									if ( isset( $field->get_args()['placeholder'] ) && ! empty( $field->get_args()['placeholder'] ) ) {
										$attr['placeholder'] = $field->get_args()['placeholder'];
									}
									if ( isset($field->get_args()['maxvalue'])  && ! empty( $field->get_args()['maxvalue'] ) ) {
										$attr['maxvalue'] = $field->get_args()['maxvalue'];
									}
									if ( isset($field->get_args()['minvalue'])  && ! empty( $field->get_args()['minvalue'] ) ) {
										$attr['minvalue'] = $field->get_args()['minvalue'];
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}

									?>
									<div class="mb-4">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
										</label>
										<input <?php finder_render_attr( 'listing_submit_number_field_' . $key, $attr ); ?>>
									</div>
									<?php
									break;
								case 'email':
									$label = $field->get_args()['label'];

									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$placeholder = $field->get_args()['placeholder'];

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_class,
										'type'        => 'email',
										'name'        => $field->get_name(),
										'placeholder' => $placeholder,

									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
									<div class="mb-4">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
										</label>
										<input <?php finder_render_attr( 'listing_submit_email_field_' . $key, $attr ); ?>>
									</div>
									<?php
									break;
								case 'date':
										$field_args           = $field->get_args();
										$label                = $field_args['label'];
										$name                 = $field->get_name();
										$placeholder          = $field_args['placeholder'];
										$is_time_enable       = $field_args['time'];
										$min_date             = $field_args['min_date'];
										$max_date             = $field_args['max_date'];
										$form_control_classes = $date_time_class;

										$data_datepicker_options = array(
											'altInput'   => true,
											'altFormat'  => 'F j, Y',
											'dateFormat' => 'Y-m-d',
										);

										if ( $is_time_enable ) {
											$data_datepicker_options['enableTime'] = true;
											$data_datepicker_options['altFormat']  = 'F j, Y h:i';
											$data_datepicker_options['dateFormat'] = 'Y-m-d H:i:S';
										}

										if ( $min_date ) {
											$data_datepicker_options['minDate'] = $min_date;
										}

										if ( $max_date ) {
											$data_datepicker_options['maxDate'] = $max_date;
										}
										?>
										<div class="mb-4">
											<label class="<?php echo esc_attr( $lable_class ); ?>">
												<?php echo esc_html( $label ); ?>
											</label>
											<div class="input-group mb-3">
												<input class="<?php echo esc_attr( $form_control_classes ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-datepicker-options='<?php echo esc_attr( wp_json_encode( $data_datepicker_options ) ); ?>'>
												<i class="fi-calendar position-absolute top-50 end-0 translate-middle-y me-3"></i>
											</div>
										</div>
										<?php
									break;
								case 'url':
									$label = $field->get_args()['label'];

									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_class,
										'type'        => 'url',
										'name'        => $field->get_name(),

									);

									if ( isset($field->get_args()['placeholder']) ) {
										$attr['placeholder'] = $field->get_args()['placeholder'];
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
								<div class="mb-4">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
											<span class="text-danger">*</span>
										<?php endif; ?>
										</label>
										<input <?php finder_render_attr( 'listing_submit_url_field_' . $key, $attr ); ?>>
								</div>
									<?php
									break;
								case 'time':
									$field_args           = $field->get_args();
									$label                = $field_args['label'];
									$name                 = $field->get_name();
									$placeholder          = $field_args['placeholder'];
									$min_value            = $field_args['min_value'];
									$max_value            = $field_args['max_value'];
									$form_control_classes = $date_time_class;


									?>
									<div class="mb-3">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
										</label>
										<div class="input-group">
											<input class="<?php echo esc_attr( $form_control_classes ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-display-format="g:i a" data-component="time">
											<i class="fi-clock position-absolute top-50 end-0 translate-middle-y me-3"></i>
										</div>
									</div>
									<?php
									break;
								case 'tel':
									$label = $field->get_args()['label'];

									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$placeholder = $field->get_args()['placeholder'];

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_class,
										'type'        => 'tel',
										'name'        => $field->get_name(),
										'placeholder' => $placeholder,

									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
									<div class="mb-4">
										<label class="<?php echo esc_attr( $lable_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
										</label>
										<input <?php finder_render_attr( 'listing_submit_tel_field_' . $key, $attr ); ?>>
									</div>
									<?php
									break;
							}
						}
						?>
						<div class="d-sm-flex justify-content-end pt-2">
							<button type="submit" class="btn btn-primary btn-lg d-block mb-2 <?php echo esc_attr( $button_class ); ?>"><?php esc_html_e( 'Save and continue', 'finder' ); ?></button>
						</div>
					</form>
				</section>	
			</div>
		</div>
	</div>
</div>

<?php
/**
 * The Template for displaying listing form
 *
 * @package Finder
 */

use HivePress\Forms\Listing_Update;
use HivePress\Menus\Listing_Manage;
use HivePress\Forms\Listing_Delete;
use HivePress\Blocks\Listing_Hide_Toggle;
use HivePress\Fields\Attachment_Upload;
use HivePress\Models;

$listing_edit_args = apply_filters(
	'finder_listing_edit_page_args',
	array(
		'model'  => $listing,
		'button' => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-4' ),
			),
		),
	)
);

$listings_edit_form = new Listing_Update( $listing_edit_args );


// $attachments = Models\Attachment::query()->filter(
// 	[
// 		'id__in' => (array) $this->value,
// 	]
// )->order( 'id__in' )
// ->get();
// $test = new Attachment_Upload();
// foreach ( $attachments as $attachment ) {
// 	print_r($attachment);
// 	$output .= $this->render_attachment( $attachment );
// }
// print_r($test->render_attachment());

$model = $listings_edit_form->get_model();

$from_action = hivepress()->router->get_url(
	'listing_update_action',
	array(
		'listing_id' => $model->get_id(),
	)
);

$listings_edit_form_fields = $listings_edit_form->get_fields();

$listing_delete_args = apply_filters(
	'finder_listing_delete_page_args',
	array(
		'model'       => $listing,
		'description' => false,
		'button'      => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'btn-sm' ),
			),
		),
	)
);

$listings_delete_form = new Listing_Delete( $listing_delete_args );

$listing_hide_args = array(
	'context' => array(
		'listing' => $listing,
	),
);

$listing_hide = new Listing_Hide_Toggle( $listing_hide_args );

$listing_manage_args = array(
	'context' => array(
		'listing' => $listing,
	),
);


$listing_manage = new Listing_Manage( $listing_manage_args );
$items          = $listing_manage->get_items();
$url            = hivepress()->router->get_current_url();

$sticky_header   = finder_is_sticky_header();
$container_class = 'container mt-5 py-5';
if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4';
}

$listing_style = finder_hivepress_get_listing_single_style();

switch ( $listing_style ) {
	case 'real-estate':
	case 'city-guide':
		$header_title_class        = 'h2 mb-4';
		$title_class               = 'h4 mb-4';
		$lable_attr_class          = 'form-label d-block fw-bold mb-2 pb-1';
		$card_class                = 'card card-body border-0 shadow-sm p-4 mb-4';
		$form_control_attr_classes = 'form-control';
		$form_checkbox_class       = 'form-check';
		$select_class              = 'form-select';
		break;

	case 'car-finder':
		$header_title_class        = 'h2 text-white mb-4';
		$title_class               = 'h4 mb-4 text-light ';
		$lable_attr_class          = 'form-label d-block fw-bold mb-2 pb-1 text-light';
		$card_class                = 'card card-light card-body border-0 shadow-sm p-4 mb-4';
		$form_control_attr_classes = 'form-control form-control-light';
		$form_checkbox_class       = 'form-check form-check-light';
		$select_class              = 'form-select form-select-light';
		break;
}
?><div class="finder-listing-single-edit-property-wrap">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<h1 class="hp-page__title <?php echo esc_attr( $header_title_class ); ?>"><?php echo esc_html__( 'Edit listing', 'finder' ); ?></h1>
				<div class="align-items-center d-md-flex justify-content-between mb-4">
					<?php if ( $items ) : ?>
						<ul class="nav nav-tabs justify-content-center card-header-tabs">
						<?php foreach ( $items as $item ) : ?>
							<?php
								$anchor_classes  = 'nav-link';
								$anchor_classes .= ( $url === $item['url'] ? ' active' : '' );
							?>
							<li class="nav-item mx-0 me-3">
								<a class="<?php echo esc_attr( $anchor_classes ); ?>" href="<?php echo esc_url( $item['url'] ); ?>">
									<?php echo esc_html( $item['label'] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<div class="align-items-center d-flex justify-content-center mt-3 mt-md-0">
						<?php echo apply_filters( 'finder_user_listing_hide_output', $listing_hide->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div class="ms-2">
							<?php echo apply_filters( 'finder_user_listing_delete_form_output', $listings_delete_form->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
				<div class="<?php echo esc_attr( $card_class ); ?>">
					<h2 class="<?php echo esc_attr( $title_class ); ?>">
						<i class="fi-edit text-primary fs-5 mt-n1 me-2"></i>
						<?php esc_html_e( 'Edit details', 'finder' ); ?>
					</h2>
					<form class="hp-form hp-form--listing-update" data-model="listing" data-id="<?php echo esc_attr( $model->get_id() ); ?>" action="#" data-message="<?php esc_attr_e( 'Changes have been saved.', 'finder' ); ?>" data-action="<?php echo esc_url( $from_action ); ?>" method="POST" data-component="form">
						<div class="hp-form__messages" data-component="messages"></div>
						<div class="hp-form__fields">
						<?php
						foreach ( $listings_edit_form_fields as $key => $field ) {
							switch ( $field->get_display_type() ) {
								case 'tel':
									$label = $field->get_args()['label'];

									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$placeholder = $field->get_args()['placeholder'];
									$value       = $field->get_value();
									
									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_attr_classes,
										'type'        => 'tel',
										'name'        => $field->get_name(),
										'placeholder' => $placeholder,
										'value'       => $field->get_value(),

									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
									<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
										<input <?php finder_render_attr( 'listing_submit_tel_field_' . $key, $attr ); ?>>
									</div>
									<?php
									break;
								case 'attachment_upload':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( 'images' . '_' );
									$form_control_attr_classes =  $form_control_attr_classes . ' mt-2 hp-field hp-field--file';
									$value       = $field->get_value();
									$multiple    = $field->get_args()['multiple'];
									
									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_attr_classes,
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
										<div <?php finder_render_attr( 'listing_submit_edit_attachment_field_hp_row' . $key, $hp_attr ); ?>><?php
										if( ! is_null( $value ) ) {
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
										}?>
										</div>
										<div class="hp-form__messages hp-form__messages--error" data-component="messages"></div>
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?>
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
									$value       = $field->get_value();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_attr_classes,
										'type'  => $field->get_display_type(),
										'name'  => $field->get_name(),
										'value' => $value,
									);

									if ( $max_length ) {
										$attr['maxlength'] = $max_length;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}

									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input <?php finder_render_attr( 'listing_edit_text_field_' . $key, $attr ); ?>>
										</div>
										<?php
									break;

								case 'location':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$max_length  = $field_args['max_length'];
									$is_required = $field->is_required();
									$value       = $field->get_value();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_attr_classes,
										'type'  => 'text',
										'name'  => $field->get_name(),
										'value' => $value,
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
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
											<?php echo esc_html( $label ); ?>
											<?php if ( $is_required ) : ?>
													<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input type="hidden" name="post_type" value="hp_listing">
											<input type="hidden" name="latitude" value="" data-coordinate="lat">
											<input type="hidden" name="longitude" value="" data-coordinate="lng">
											<div data-countries="<?php echo esc_attr( $countries ); ?>" data-component="location">
												<input <?php finder_render_attr( 'listing_edit_submit_location_field_' . $key, $attr ); ?>>
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
									$value       = $field->get_value();

									$attr = array(
										'id'    => $unique_id,
										'class' => $form_control_attr_classes,
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
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<textarea <?php finder_render_attr( 'listing_edit_textarea_field_' . $key, $attr ); ?>><?php echo esc_html( $value ); ?></textarea>
										</div>
										<?php
									break;

								case 'number':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$value       = $field->get_value();
									$placeholder = $field->get_args()['placeholder'];
									$min_value   = $field->get_args()['min_value'];
									$max_value   = $field->get_args()['max_value'];

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_attr_classes,
										'type'        => $field->get_display_type(),
										'name'        => $field->get_name(),
										'value'       => $value,
										'placeholder' => $placeholder,
										'min_value'   => $min_value,
										'max_value'   => $max_value,
									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
											</label>
											<input <?php finder_render_attr( 'listing_edit_textarea_field_' . $key, $attr ); ?>>
										</div>
										<?php
									break;

								case 'select':
									$label       = $field->get_args()['label'];
									$placeholder = $field->get_args()['placeholder'];
									$multiple    = $field->get_args()['multiple'];
									$options     = $field->get_args()['options'];

									$select_attr = array(
										'class' => $select_class,
										'name'  => $field->get_name(),
									);
									if ( isset( $multiple ) && $multiple ) {
										$select_attr['name']    .= '[]';
										$select_attr['multiple'] = true;
									}

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?> 
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<select <?php finder_render_attr( 'listing_edit_select_', $select_attr ); ?>>
											<?php foreach ( $options as $key => $option ) : ?>
													<?php
														$select_options_attr = array(
															'value' => $key,
														);
														?>
													<option <?php finder_render_attr( 'listing_edit_select_options_' . $key, $select_options_attr ); ?>><?php echo esc_html( $option['label'] ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<?php
									break;

								case 'email':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$max_length  = $field_args['max_length'];
									$is_required = $field->is_required();
									$value       = $field->get_value();
									$placeholder = $field->get_args()['placeholder'];

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_attr_classes,
										'type'        => $field->get_display_type(),
										'name'        => $field->get_name(),
										'value'       => $value,
										'placeholder' => $placeholder,
									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input <?php finder_render_attr( 'listing_edit_email_field_' . $key, $attr ); ?>>
										</div>
										<?php
									break;

								case 'url':
									$field_args  = $field->get_args();
									$label       = $field->get_label();
									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$value       = $field->get_value();
									$placeholder = $field->get_args()['placeholder'];

									$attr = array(
										'id'          => $unique_id,
										'class'       => $form_control_attr_classes,
										'type'        => $field->get_display_type(),
										'name'        => $field->get_name(),
										'value'       => $value,
										'placeholder' => $placeholder,
									);

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<input <?php finder_render_attr( 'listing_edit_email_field_' . $key, $attr ); ?>>
										</div>
										<?php
									break;
								case 'checkbox':
									$label       = $field->get_args()['label'];
									$caption     = $field->get_args()['caption'];
									$unique_id   = uniqid( $field->get_name() . '_' );
									$is_required = $field->is_required();
									$check_value = true;
									$value       = $field->get_value();

									if ( $is_required ) {
										$attr['required'] = true;
									}
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
										<?php if ( $is_required ) : ?>
												<span class="text-danger">*</span>
											<?php endif; ?>
											</label>
											<div class="<?php echo esc_attr( $form_checkbox_class ); ?> mb-3">
												<input class="form-check-input" id="<?php echo esc_attr( $unique_id ); ?>" type="checkbox" name="<?php echo esc_attr( $field->get_name() ); ?>" <?php checked( $value, $check_value ); ?>>
												<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $label ); ?></label>
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
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>">
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
													<div class="<?php echo esc_attr( $form_checkbox_class ); ?>">
														<input <?php finder_render_attr( 'listing_edit_checkboxes_field_' . $key, $attr ); ?>>
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
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>"><?php echo esc_html( $label ); ?></label>
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
												<div class="<?php echo esc_attr( $form_checkbox_class ); ?>">
													<input <?php finder_render_attr( 'listing_submit_radio_field_' . $key, $attr ); ?>>
													<label class="form-check-label" for="<?php echo esc_attr( $unique_id ); ?>">
														<?php echo esc_html( $value['label'] ); ?> 
													</label>
												</div>
											<?php endforeach; ?>
										</div>
									<?php
									break;

								case 'date':
									$input_class = '';
									if ( 'car-finder' === $listing_style ) {
										$input_class = ' form-control-light';
									}
									$field_args           = $field->get_args();
									$label                = $field_args['label'];
									$name                 = $field->get_name();
									$placeholder          = $field_args['placeholder'];
									$is_time_enable       = $field_args['time'];
									$min_date             = $field_args['min_date'];
									$max_date             = $field_args['max_date'];
									$form_control_classes = $input_class;

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
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
											</label>
											<div class="input-group mb-3">
												<input class="<?php echo esc_attr( $form_control_classes ); ?> date-picker rounded pe-5" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-datepicker-options='<?php echo esc_attr( wp_json_encode( $data_datepicker_options ) ); ?>'>
												<i class="fi-calendar position-absolute top-50 end-0 translate-middle-y me-3"></i>
											</div>
										</div>
										<?php
									break;

								case 'time':
									$input_class = '';
									if ( 'car-finder' === $listing_style ) {
										$input_class = ' form-control-light';
									}
									$field_args  = $field->get_args();
									$label       = $field_args['label'];
									$name        = $field->get_name();
									$min_value   = $field_args['min_value'];
									$max_value   = $field_args['max_value'];
									$placeholder = $field_args['placeholder'];

									$form_control_classes .= $input_class;
									?>
										<div class="mb-3">
											<label class="<?php echo esc_attr( $lable_attr_class ); ?>" for="<?php echo esc_attr( $unique_id ); ?>">
										<?php echo esc_html( $label ); ?>
											</label>
											<div class="input-group">
												<input class="<?php echo esc_attr( $form_control_classes ); ?> date-picker rounded pe-5" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-display-format="g:i a" data-component="time">
												<i class="fi-clock position-absolute top-50 end-0 translate-middle-y me-3"></i>
											</div>
										</div>
										<?php
									break;
							}
						}
						?>
						</div>
						<button type="submit" class="btn btn-primary px-3 px-sm-4"><?php esc_html_e( 'Save Changes', 'finder' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

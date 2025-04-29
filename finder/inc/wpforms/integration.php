<?php
/**
 * WP Forms Integration
 */

add_filter( 'transient_wpforms_activation_redirect', '__return_false' );

add_filter( 'wpforms_field_properties_text', 'finder_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_textarea', 'finder_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_number', 'finder_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_email', 'finder_wpforms_inputs_properties', 10, 3 );
add_filter( 'wpforms_field_properties_select', 'finder_wpforms_select_properties', 10, 3 );
add_filter( 'wpforms_field_properties_name', 'finder_wpforms_name_properties', 10, 3 );

add_filter( 'wpforms_frontend_form_atts', 'finder_wpforms_frontend_form_atts', 10, 2 );

add_action( 'wpforms_form_settings_general', 'finder_wpforms_settings_general', 10, 1 );

/**
 * Override Input field.
 *
 * @param array $properties The field properties.
 * @param array $field      The form field.
 * @param array $form_data  The form data.
 */
function finder_wpforms_inputs_properties( $properties, $field, $form_data ) {
	$properties['inputs']['primary']['class'][] = 'form-control';
	$properties['inputs']['primary']['class'][] = 'form-control-lg';

	if ( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['light_version'] ) && ! empty( $form_data['settings']['enable']['light_version'] ) ) {
			$properties['inputs']['primary']['class'][] = 'form-control-light';

	}

	if ( 'textarea' === $field['type'] ) {
		$properties['inputs']['primary']['attr']['rows'] = '4';
	}

	return $properties;
}

/**
 * Override Select field.
 *
 * @param array $properties The field properties.
 * @param array $field      The form field.
 * @param array $form_data  The form data.
 */
function finder_wpforms_select_properties( $properties, $field, $form_data ) {
	$properties['input_container']['class'][] = 'form-select';
	$properties['input_container']['class'][] = 'form-select-lg';

	if ( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['light_version'] ) && ! empty( $form_data['settings']['enable']['light_version'] ) ) {
		$properties['input_container']['class'][] = 'form-select-light';

	}

	return $properties;
}

/**
 * Override Name field.
 *
 * @param array $properties The field properties.
 * @param array $field      The form field.
 * @param array $form_data  The form data.
 */
function finder_wpforms_name_properties( $properties, $field, $form_data ) {
	foreach ( $properties['inputs'] as $key => $input ) {
		$properties['inputs'][ $key ]['class'][] = 'form-control';
		$properties['inputs'][ $key ]['class'][] = 'form-control-lg';

		if ( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['light_version'] ) && ! empty( $form_data['settings']['enable']['light_version'] ) ) {
				$properties['inputs'][ $key ]['class'][] = 'form-control-light';

		}
	}
	return $properties;
}

/**
 * Override Form attributes
 *
 * @param array $form_atts The form attributes.
 * @param array $form_data The form data.
 */
function finder_wpforms_frontend_form_atts( $form_atts, $form_data ) {
	if ( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['make_row'] ) && ! empty( $form_data['settings']['enable']['make_row'] ) ) {
		$form_atts['class'][] = 'd-flex';
		$form_atts['class'][] = 'w-100';

	}

	if ( isset( $form_data['settings']['enable'] ) && isset( $form_data['settings']['enable']['light_version'] ) && ! empty( $form_data['settings']['enable']['light_version'] ) ) {
		$form_atts['class'][] = 'wpform-light';
	}

	return $form_atts;
}

if ( ! function_exists( 'finder_wpforms_settings_general' ) ) {
	/**
	 * Additional General Settings.
	 *
	 * @param array $settings Settings array.
	 */
	function finder_wpforms_settings_general( $settings ) {

		wpforms_panel_field(
			'checkbox',
			'enable',
			'make_row',
			$settings->form_data,
			esc_html__( 'Enable Form Row', 'finder' ),
			array(
				'class'       => 'wpforms-panel-field-enable-make_row-wrap',
				'input_class' => 'wpforms-panel-field-enable-make_row',
				'parent'      => 'settings',

			)
		);

		wpforms_panel_field(
			'checkbox',
			'enable',
			'light_version',
			$settings->form_data,
			esc_html__( 'Enable Light Version', 'finder' ),
			array(
				'class'       => 'wpforms-panel-field-enable-light_version-wrap',
				'input_class' => 'wpforms-panel-field-enable-light_version',
				'parent'      => 'settings',

			)
		);
	}
}

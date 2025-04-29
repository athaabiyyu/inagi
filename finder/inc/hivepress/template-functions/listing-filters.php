<?php
/**
 * Finder HivePress Listings Filters Functions
 *
 * @package Finder
 */

if ( ! function_exists( 'finder_hivepress_listing_category_filters' ) ) {
	/**
	 * Display hivepress listings category filters.
	 *
	 * @param array  $listing_filter_fields array of fields.
	 * @param string $variant variant of filters.
	 */
	function finder_hivepress_listing_category_filters( $listing_filter_fields = array(), $variant = 'light' ) {

		if ( ! is_array( $listing_filter_fields ) || ! isset( $listing_filter_fields['_category'] ) || empty( $listing_filter_fields['_category'] ) ) {
			return;
		}

		$categories = $listing_filter_fields['_category']->get_args();

		if ( empty( $categories['options'] ) ) {
			return;
		}

		$label_classes = 'h6';

		if ( 'dark' === $variant ) {
			$label_classes .= ' text-light';
		}

		?>
		<div class="pb-4 mb-2">
			<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php esc_html_e( 'Categories', 'finder' ); ?></h3>
			<?php foreach ( $categories['options'] as $key => $category ) : ?>
				<?php
					$unique_id = uniqid();

					$wrapper_classes = 'form-check';

				if ( 'dark' === $variant ) {
					$wrapper_classes .= ' form-check-light';
				}

				if ( isset( $category['parent'] ) && $category['parent'] ) {
					$wrapper_classes .= '';
				}
				?>
				<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
					<input class="btn-check" id="_category_<?php echo esc_attr( $unique_id ); ?>" type="radio" name="<?php echo esc_attr( $categories['name'] ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $categories['default'], $key ); ?>>
					<label class="btn btn-outline-primary" for="_category_<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $category['label'] ); ?></label>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_attribute_filters' ) ) {
	/**
	 * Display hivepress listings atribute filters.
	 *
	 * @param array  $listing_filter_fields array of fields.
	 * @param string $variant variant of filters.
	 */
	function finder_hivepress_listing_attribute_filters( $listing_filter_fields = array(), $variant = 'light' ) {

		if ( ! is_array( $listing_filter_fields ) ) {
			return;
		}

		foreach ( $listing_filter_fields as $key => $field ) {

			$label_classes        = 'h6';
			$form_control_classes = 'form-control';

			if ( 'dark' === $variant ) {
				$label_classes        .= ' text-light';
				$form_control_classes .= ' form-control-light';
			}

			switch ( $field->get_display_type() ) {
				case 'number_range':
					$label           = $field->get_label();
					$min_value       = $field->get_args()['min_value'];
					$max_value       = $field->get_args()['max_value'];
					$start_min_value = $min_value;
					$start_max_value = $max_value;
					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
					$attribute_view_style = finder_get_field( 'set_number_range_style', $attribute_id );
					$number_range_prefix = finder_get_field( 'number_range_prefix', $attribute_id );

					if ( isset( $_GET[ $field->get_name() ] ) && is_array( $_GET[ $field->get_name() ] ) && ! empty( $_GET[ $field->get_name() ] ) ) {
						$start_values    = filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );

						if ( isset( $start_values[0] ) ) {
							$start_min_value = $start_values[0];
						}

						if ( isset( $start_values[1] ) ) {
							$start_max_value = $start_values[1];
						}
					} elseif ( get_query_var( $field->get_name() ) ) {
						$start_values    = get_query_var( $field->get_name() );

						if ( isset( $start_values[0] ) ) {
							$start_min_value = $start_values[0];
						}

						if ( isset( $start_values[1] ) ) {
							$start_max_value = $start_values[1];
						}
					}

					$range_slider_classes = 'range-slider';

					if ( 'dark' === $variant ) {
						$range_slider_classes .= ' range-slider-light';
					}

					$form_control_min_classes = $form_control_classes . ' range-slider-value-min';
					$form_control_max_classes = $form_control_classes . ' range-slider-value-max';

					if ( $min_value && $max_value ) {
						if ( 'style1' === $attribute_view_style ) : 
						?>
						<div class="pb-4 mb-2">
							<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
							<div class="<?php echo esc_attr( $range_slider_classes ); ?>" data-currency="<?php echo esc_attr( $number_range_prefix ); ?>" data-start-min="<?php echo esc_attr( $start_min_value ); ?>" data-start-max="<?php echo esc_attr( $start_max_value ); ?>" data-min="<?php echo esc_attr( $min_value ); ?>" data-max="<?php echo esc_attr( $max_value ); ?>" data-step="1">
								<div class="range-slider-ui"></div>
								<div class="d-flex align-items-center">
									<div class="w-50 pe-2">
										<div class="input-group">
											<?php if ( ! empty( $number_range_prefix ) ) : ?>
											<span class="input-group-text"><?php echo esc_attr( $number_range_prefix ); ?></span>
											<?php endif; ?>
											<input class="<?php echo esc_attr( $form_control_min_classes ); ?>" type="number" name="<?php echo esc_attr( $field->get_name() ); ?>[]">
										</div>
									</div>
									<div class="text-muted">&mdash;</div>
									<div class="w-50 ps-2">
										<div class="input-group">
											<?php if ( ! empty( $number_range_prefix ) ) : ?>
											<span class="input-group-text"><?php echo esc_attr( $number_range_prefix ); ?></span>
											<?php endif; ?>
											<input class="<?php echo esc_attr( $form_control_max_classes ); ?>" type="number" name="<?php echo esc_attr( $field->get_name() ); ?>[]">
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php if ( 'style2' === $attribute_view_style ) : ?>
							<div class="pb-4 mb-2">
								<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
								<div class="d-flex align-items-center">
									<div class="w-50 pe-2">
										<div class="input-group">
										<?php if ( ! empty( $number_range_prefix ) ) : ?>
											<span class="input-group-text"><?php echo esc_attr( $number_range_prefix ); ?></span>
										<?php endif; ?>
											<input class="<?php echo esc_attr( $form_control_min_classes ); ?>" type="number" name="<?php echo esc_attr( $field->get_name() ); ?>[]" placeholder="Min">
										</div>
									</div>
									<div class="text-muted">&mdash;</div>
									<div class="w-50 ps-2">
										<div class="input-group">
										<?php if ( ! empty( $number_range_prefix ) ) : ?>
											<span class="input-group-text"><?php echo esc_attr( $number_range_prefix ); ?></span>
										<?php endif; ?>
											<input class="<?php echo esc_attr( $form_control_max_classes ); ?>" type="number" name="<?php echo esc_attr( $field->get_name() ); ?>[]" placeholder="Max">
										</div>
									</div>
								</div>
							</div>
						<?php endif;
					}
					break;

				case 'text':
				case 'number':
					$label       = $field->get_label();
					$field_args  = $field->get_args();
					$placeholder = '';
					$min         = '';
					$max         = '';

					if ( isset( $field_args['placeholder'] ) && $field_args['placeholder'] ) {
						$placeholder = $field_args['placeholder'];
					}

					if ( 'text' === $field->get_display_type() ) {
						if ( isset( $field_args['min_length'] ) && $field_args['min_length'] ) {
							$min = $field_args['min_length'];
						}

						if ( isset( $field_args['max_length'] ) && $field_args['max_length'] ) {
							$max = $field_args['max_length'];
						}
					}

					if ( 'number' === $field->get_display_type() ) {
						if ( isset( $field_args['min_value'] ) && $field_args['min_value'] ) {
							$min = $field_args['min_value'];
						}

						if ( isset( $field_args['max_value'] ) && $field_args['max_value'] ) {
							$max = $field_args['max_value'];
						}
					}

					$value = '';
					if ( isset( $_GET[ $field->get_name() ] ) ) {
						if ( 'text' === $field->get_display_type() ) {
							$value = finder_clean( filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_SANITIZE_STRING ) );
						} else {
							$value = finder_clean( filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_SANITIZE_NUMBER_INT ) );
						}
					} elseif ( get_query_var( $field->get_name() ) ) {
						$value = get_query_var( $field->get_name() );
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<?php if ( 'text' === $field->get_display_type() ) : ?>
							<input class="<?php echo esc_attr( $form_control_classes ); ?>" type="<?php echo esc_attr( $field->get_display_type() ); ?>" name="<?php echo esc_attr( $field->get_name() ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" minlength="<?php echo esc_attr( $min ); ?>" maxlength="<?php echo esc_attr( $max ); ?>" value="<?php echo esc_attr( $value ); ?>">
						<?php elseif ( 'number' === $field->get_display_type() ) : ?>
							<input class="<?php echo esc_attr( $form_control_classes ); ?>" type="<?php echo esc_attr( $field->get_display_type() ); ?>" name="<?php echo esc_attr( $field->get_name() ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" value="<?php echo esc_attr( $value ); ?>">
						<?php endif; ?>
					</div>
					<?php
					break;

				case 'select':
					$label       = $field->get_args()['label'];
					$placeholder = $field->get_args()['placeholder'];
					$multiple    = $field->get_args()['multiple'];
					$options     = $field->get_args()['options'];

					$select_attr = array(
						'class' => 'form-select',
						'name'  => $field->get_name(),
					);

					if ( 'dark' === $variant ) {
						$select_attr['class'] .= ' form-select-light';
					}

					if ( isset( $multiple ) && $multiple ) {
						$select_attr['name']    .= '[]';
						$select_attr['multiple'] = true;
					}

					$selected = '';
					if ( isset( $_GET[ $field->get_name() ] ) && ! empty( $_GET[ $field->get_name() ] ) ) {
						$selected = filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
					} elseif ( get_query_var( $field->get_name() ) ) {
						$selected = get_query_var( $field->get_name() );
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<select <?php finder_render_attr( 'listing_attribute_filter_select', $select_attr ); ?>>
                            <?php $counting = 1;
                            foreach ( $options as $key => $option ) : ?>
                                <?php
                                    $select_options_attr = array(
                                        'value' => $key,
                                    );

                                    if ( isset( $selected ) && ! empty( $selected ) ) {
                                        if ( is_array( $selected ) && in_array( $key, $selected ) || $key == (int) $selected ) {
                                            $select_options_attr['selected'] = true;
                                        }
                                    }
                                    if ( 1 === $counting ){
                                        $select_options_attr = array(
                                            'value' => 'all',
                                            'name'  => 'All'
                                        );
                                        ?>
                                        <option <?php finder_render_attr( 'listing_attribute_filter_select_options_' . $key, $select_options_attr ); ?>><?php echo esc_html__( 'Select', 'finder' ); ?></option>
                                        <?php
                                        $select_options_attr = array(
                                            'value' => $key,
                                            'name'  => $field->get_name(),
                                        );
                                    }
                                    ?>
                                <option <?php finder_render_attr( 'listing_attribute_filter_select_options_' . $key, $select_options_attr ); ?>><?php echo esc_html( $option['label'] ); ?></option>
                            	<?php $counting++;
						 	endforeach; ?>
                        </select>
					</div>
					<?php
					break;

				case 'radio':
					if ( isset( $field->get_args()['option_args'] ) && isset( $field->get_args()['option_args']['taxonomy'] ) && 'hp_listing_category' === $field->get_args()['option_args']['taxonomy'] ) {
						break;
					}
					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
					$attribute_view_style = finder_get_field( 'set_radio_filter_style', $attribute_id );

					$label   = $field->get_args()['label'];
					$options = $field->get_args()['options'];

					$value = '';

					if ( isset( $_GET[ $field->get_name() ] ) ) {
						$value = finder_clean( filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_SANITIZE_NUMBER_INT ) );
					} elseif ( get_query_var( $field->get_name() ) ) {
						$value = get_query_var( $field->get_name() );
					}

					?>
					<?php if ( 'style1' === $attribute_view_style ) : ?>
						<div class="pb-4 mb-2">
							<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
							<?php foreach ( $options as $key => $option ) : ?>
								<?php
									$unique_id = $field->get_name() . '_' . uniqid();

									$wrapper_classes = 'form-check';

								if ( 'dark' === $variant ) {
									$wrapper_classes .= ' form-check-light';
								}
								?>
								<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
									<input class="form-check-input" id="<?php echo esc_attr( $unique_id ); ?>" type="radio" name="<?php echo esc_attr( $field->get_name() ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $value, $key ); ?>>
									<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $option['label'] ); ?></label>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif;?>
					<?php if ( 'style2' === $attribute_view_style ) : ?>
						<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<div class="btn-group btn-group-sm" role="group" aria-label="Choose number of <?php echo esc_html( $label ); ?>">
							<?php foreach ( $options as $key => $option ) : ?>
								<?php
									$unique_id = $field->get_name() . '_' . uniqid();
								?>
								<input class="btn-check" id="<?php echo esc_attr( $unique_id ); ?>" type="radio" name="<?php echo esc_attr( $field->get_name() ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( $value, $key ); ?>>
								<label class="btn btn-outline-secondary fw-normal" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $option['label'] ); ?></label>
							<?php endforeach; ?>
						</div>
						</div>
					<?php endif;?>
					<?php
					break;

				case 'checkbox':
					$label   = $field->get_args()['label'];
					$caption = $field->get_args()['caption'];

					$check_value = true;
					$value       = '';

					if ( isset( $_GET[ $field->get_name() ] ) || get_query_var( $field->get_name() ) ) {
						$value = true;
					}

					$unique_id = $field->get_name() . '_' . uniqid();

					$wrapper_classes = 'form-check';

					if ( 'dark' === $variant ) {
						$wrapper_classes .= ' form-check-light';
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
							<input class="form-check-input" id="<?php echo esc_attr( $unique_id ); ?>" type="checkbox" name="<?php echo esc_attr( $field->get_name() ); ?>" <?php checked( $value, $check_value ); ?>>
							<?php if ( $caption ) : ?>
								<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $caption ); ?></label>
							<?php endif; ?>
						</div>
					</div>
					<?php
					break;

				case 'checkboxes':
					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
					$attribute_view_style = finder_get_field( 'set_filter_style', $attribute_id );

					if ( 'style1' == $attribute_view_style ) {
						break;
					}
					
					$label   = $field->get_args()['label'];
					$options = $field->get_args()['options'];

					$selected = '';
					if ( isset( $_GET[ $field->get_name() ] ) && ! empty( $_GET[ $field->get_name() ] ) ) {
						$selected = filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
					} elseif ( get_query_var( $field->get_name() ) ) {
						$selected = get_query_var( $field->get_name() );
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<?php if ( count( $options ) > 6 ) : ?>
							<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
						<?php endif; ?>
						<?php foreach ( $options as $key => $option ) : ?>
							<?php
								$unique_id = $field->get_name() . '_' . uniqid();

								$wrapper_classes = 'form-check';

							if ( 'dark' === $variant ) {
								$wrapper_classes .= ' form-check-light';
							}

								$checkbox_options_attr = array(
									'id'    => $unique_id,
									'type'  => 'checkbox',
									'class' => 'form-check-input',
									'value' => $key,
									'name'  => $field->get_name() . '[]',

								);

								if ( isset( $selected ) && ! empty( $selected ) ) {
									if ( is_array( $selected ) && in_array( $key, $selected ) || $key == (int) $selected ) {
										$checkbox_options_attr['checked'] = true;
									}
								}
								?>
							<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
								<input <?php finder_render_attr( 'listing_attribute_filter_select_options_' . $key, $checkbox_options_attr ); ?>>
								<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $option['label'] ); ?></label>
							</div>
						<?php endforeach; ?>
						<?php if ( count( $options ) > 6 ) : ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
					break;

				case 'date':
					$field_args     = $field->get_args();
					$label          = $field_args['label'];
					$name           = $field->get_name();
					$placeholder    = $field_args['placeholder'];
					$is_time_enable = $field_args['time'];
					$min_date       = $field_args['min_date'];
					$max_date       = $field_args['max_date'];

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

					$value = '';
					if ( isset( $_GET[ $field->get_name() ] ) && ! empty( $_GET[ $field->get_name() ] ) ) {
						$value = finder_clean( filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_SANITIZE_STRING ) );
					} elseif ( get_query_var( $field->get_name() ) ) {
						$value = get_query_var( $field->get_name() );
					}

					$form_control_classes .= ' date-picker rounded pe-5';

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<div class="input-group">
							<input class="<?php echo esc_attr( $form_control_classes ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-datepicker-options='<?php echo esc_attr( wp_json_encode( $data_datepicker_options ) ); ?>'>
							<i class="fi-calendar position-absolute top-50 end-0 translate-middle-y me-3"></i>
						</div>
					</div>
					<?php
					break;

				case 'date_range':
					$field_args     = $field->get_args();
					$label          = $field_args['label'];
					$name           = $field->get_name();
					$placeholder    = $field_args['placeholder'];
					$is_time_enable = $field_args['time'];
					$min_date       = $field_args['min_date'];
					$max_date       = $field_args['max_date'];

					$data_datepicker_options = array(
						'altInput'   => true,
						'altFormat'  => 'F j, Y',
						'dateFormat' => 'Y-m-d',
						'mode'       => 'range',
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

					$values = '';

					if ( isset( $_GET[ $field->get_name() ] ) && is_array( $_GET[ $field->get_name() ] ) && ! empty( $_GET[ $field->get_name() ] ) ) {
						$values = filter_var( wp_unslash( $_GET[ $field->get_name() ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
					} elseif ( get_query_var( $field->get_name() ) ) {
						$values = get_query_var( $field->get_name() );
					}

					$values_to_string = '';
					if ( $values && is_array( $values ) ) {
						$values_to_string = join( ' to ', $values );
					}

					$unique_id = uniqid();

					$form_control_classes_start = $form_control_classes . ' date-picker date-range';
					$form_control_classes_end   = $form_control_classes . ' date-picker';
					$input_group_text_classes   = 'input-group-text';

					if ( 'dark' === $variant ) {
						$input_group_text_classes .= ' form-control-light text-body';
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( $label ); ?></h3>
						<div class="input-group finder-date-range">
							<span class="<?php echo esc_attr( $input_group_text_classes ); ?>">
								<i class="fi-calendar"></i>
							</span>
							<input class="<?php echo esc_attr( $form_control_classes_start ); ?>" type="text" value="<?php echo esc_attr( $values_to_string ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" data-datepicker-options='<?php echo esc_attr( wp_json_encode( $data_datepicker_options ) ); ?>' data-linked-input="#end-date-<?php echo esc_attr( $unique_id ); ?>">
							<input type="hidden" name="<?php echo esc_attr( $name ); ?>[]" class="finder-hidden-field">
							<input type="hidden" name="<?php echo esc_attr( $name ); ?>[]" class="finder-hidden-field">
							<input class="<?php echo esc_attr( $form_control_classes_end ); ?>" type="text" placeholder="<?php esc_attr_e( 'To date', 'finder' ); ?>" data-datepicker-options='<?php echo esc_attr( wp_json_encode( $data_datepicker_options ) ); ?>' id="end-date-<?php echo esc_attr( $unique_id ); ?>">
						</div>
					</div>
					<?php
					break;
			}
		}
	}
}

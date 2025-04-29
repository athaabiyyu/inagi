<?php
/**
 * Custom Settings for Listing single post
 *
 * @package Finder/ACF/Settings/Listing single post
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_61652091a94ac',
		'title'                 => 'Finder Listing Single Options',
		'fields'                => array(
			array(
				'key'               => 'field_616520bf7d3dc',
				'label'             => 'Listing Style',
				'name'              => 'single_listing_style',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'default'     => 'Default',
					'real-estate' => 'Real Estate',
					'car-finder'  => 'Car Finder',
					'city-guide'  => 'City Guide',
				),
				'default_value'     => 'default',
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 1,
				'ajax'              => 0,
				'return_format'     => 'value',
				'placeholder'       => '',
			),
			array(
				'key'               => 'field_6165566d76380',
				'label'             => 'Related Listing ?',
				'name'              => 'related_listing_enable_disable',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => '',
				'default_value'     => 1,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_6165852fb44bc',
				'label'             => 'Related Listing Title',
				'name'              => 'related_listing_title',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_6165566d76380',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => 'Related Posts',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_616589d0820cb',
				'label'             => 'Related Listing Action Text',
				'name'              => 'related_listing_action_text',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_6165566d76380',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => 'View All',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_6165884006a16',
				'label'             => 'Related Listing Action Text URL',
				'name'              => 'related_listing_text_url',
				'type'              => 'url',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_6165566d76380',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'hp_listing',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	)
);

<?php
/**
 * Custom Settings for Vendor single post
 *
 * @package Finder/ACF/Settings/Vendor single post
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_616e5dc7c629b',
		'title'                 => 'Finder Vendor Attributes Options',
		'fields'                => array(
			array(
				'key'               => 'field_616e5df9760fa',
				'label'             => 'Single Vendor Style',
				'name'              => 'single_vendor_style',
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
				'ui'                => 0,
				'return_format'     => 'value',
				'ajax'              => 0,
				'placeholder'       => '',
			),
			array(
				'key'               => 'field_616e60b217dc1',
				'label'             => 'Car Finder Vendor View Style',
				'name'              => 'car_finder_vendor_view_style',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616e5df9760fa',
							'operator' => '==',
							'value'    => 'car-finder',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'default'  => 'Default',
					'button'   => 'Button',
					'link'     => 'Link',
					'location' => 'Location',
					'detail'   => 'Detail',
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
				'key'               => 'field_6171022d1a291',
				'label'             => 'Real Estate Vendor View Style',
				'name'              => 'real_estate_vendor_view_style',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616e5df9760fa',
							'operator' => '==',
							'value'    => 'real-estate',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'default'  => 'Default',
					'contacts' => 'Contacts',
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
				'key'               => 'field_617124b0aa772',
				'label'             => 'City Guide Vendor View Style',
				'name'              => 'city_guide_vendor_view_style',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616e5df9760fa',
							'operator' => '==',
							'value'    => 'city-guide',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'default'  => 'Default',
					'contacts' => 'Contacts',
					'details'  => 'Details',
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
				'key'               => 'field_61716f5ef8201',
				'label'             => 'Single Vendor Icon Classes',
				'name'              => 'single_vendor_icon_classes',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_6177ea7b2f503',
				'label'             => 'Archive Vendor Icon Classes',
				'name'              => 'archive_vendor_icon_classes',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'hp_vendor_attribute',
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
acf_add_local_field_group(
	array(
		'key'                   => 'group_617299f466983',
		'title'                 => 'Finder Vendor Options',
		'fields'                => array(
			array(
				'key'               => 'field_61729a0ab2e2c',
				'label'             => 'Vendor Styles',
				'name'              => 'vendor_styles',
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
				'ui'                => 0,
				'return_format'     => 'value',
				'ajax'              => 0,
				'placeholder'       => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'hp_vendor',
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


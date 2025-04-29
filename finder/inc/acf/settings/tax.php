<?php
/**
 * Custom Settings for Taxonomy
 *
 * @package Blogzine/ACF/Settings/Taxonomy
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_61487a243ba70',
		'title'                 => 'Blog Options',
		'fields'                => array(
			array(
				'key'               => 'field_61487a415d5f1',
				'label'             => 'Blog Styles',
				'name'              => 'blog_styles',
				'type'              => 'select',
				'instructions'      => 'Select blog post version',
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
					'job-board'   => 'Job Board',
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
				'key'               => 'field_617148f72aeb0',
				'label'             => 'Blog Column',
				'name'              => 'blog_column',
				'type'              => 'select',
				'instructions'      => 'Select Column',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_61487a415d5f1',
							'operator' => '!=',
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
					'default' => 'Default',
					1         => '1',
					2         => '2',
					3         => '3',
					4         => '4',
					5         => '5',
					6         => '6',
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
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'post_tag',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
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
		'key'                   => 'group_617931c9a4203',
		'title'                 => 'Finder Listing Category Options',
		'fields'                => array(
			array(
				'key'               => 'field_617931d480838',
				'label'             => 'Category Icon Class',
				'name'              => 'hp_listing_category_icon',
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
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'hp_listing_category',
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

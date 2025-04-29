<?php
/**
 * Custom Settings for Single post
 *
 * @package Blogzine/ACF/Settings/Single post
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_61487b618084d',
		'title'                 => 'Finder Single Post Options',
		'fields'                => array(
			array(
				'key'               => 'field_618a0af039a73',
				'label'             => 'Is New Post',
				'name'              => 'is_new_post',
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
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_61714f556faaf',
				'label'             => 'Blog Badge',
				'name'              => 'blog_post_badge',
				'type'              => 'radio',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_618a0af039a73',
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
				'choices'           => array(
					'yes' => 'yes',
					'no'  => 'no',
				),
				'allow_null'        => 0,
				'other_choice'      => 0,
				'default_value'     => 'no',
				'layout'            => 'vertical',
				'return_format'     => 'value',
				'save_other_choice' => 0,
			),
			array(
				'key'               => 'field_6148783650b41',
				'label'             => 'Single Post Styles',
				'name'              => 'single_post_styles',
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
					'job-board'   => 'Job Board',
					'city-guide'  => 'City Guide',
					'car-finder'  => 'Car Finder',
				),
				'default_value'     => false,
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 1,
				'ajax'              => 0,
				'return_format'     => 'value',
				'placeholder'       => '',
			),
			array(
				'key'               => 'field_614970181348c',
				'label'             => 'Single Post Social Share',
				'name'              => 'single_post_social_share',
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
				'default_value'     => 0,
				'ui'                => 1,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
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
		'key'                   => 'group_61485f9b8d8aa',
		'title'                 => 'Finder User Options',
		'fields'                => array(
			array(
				'key'               => 'field_61485fcd448b6',
				'label'             => 'Single post author by line',
				'name'              => 'single_post_author_by_line',
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
				'key' => 'field_62a07f54a97e6',
				'label' => 'Social Profile Links',
				'name' => 'social_profile_links',
				'type' => 'textarea',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'new_lines' => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'user_role',
					'operator' => '==',
					'value'    => 'all',
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
		'key'                   => 'group_6188d98ddc8ef',
		'title'                 => 'Cover Image',
		'fields'                => array(
			array(
				'key'               => 'field_6188d995084ca',
				'label'             => 'Cover Image',
				'name'              => 'cover_url',
				'type'              => 'image',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'return_format'     => 'url',
				'preview_size'      => 'full',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
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

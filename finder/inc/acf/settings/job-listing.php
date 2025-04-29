<?php
/**
 * Custom Settings for Jobmanager single post
 *
 * @package Finder/ACF/Settings/Jobmanager single post
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_61659dd51fe9e',
		'title'                 => 'Finder Job single',
		'fields'                => array(
			array(
				'key'               => 'field_616688a647cdf',
				'label'             => 'Related job enable disable',
				'name'              => 'related_job_enable_disable',
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
				'ui'                => 0,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_6166913cddac2',
				'label'             => 'Related	job title text',
				'name'              => 'related_job_title_text',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616688a647cdf',
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
				'default_value'     => 'You may be interested in',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_6166919ccdc7c',
				'label'             => 'Related	job action text',
				'name'              => 'related_job_action_text',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616688a647cdf',
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
				'key'               => 'field_6166927d200bf',
				'label'             => 'Related	job action text url',
				'name'              => 'related_job_action_text_url',
				'type'              => 'url',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616688a647cdf',
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
			array(
				'key'               => 'field_6166c709e75b3',
				'label'             => 'Related job per page',
				'name'              => 'related_job_per_page',
				'type'              => 'number',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_616688a647cdf',
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
				'default_value'     => 1,
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'job_listing',
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

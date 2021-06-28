<?php
/**
 * The template for adding Featured Content Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */


$wp_customize->add_panel( 'clean_business_featured_content', array(
    'capability'     => 'edit_theme_options',
	'description'    => esc_html__( 'Options for Featured Content', 'clean-business' ),
    'priority'       => 400,
    'title'    		 => esc_html__( 'Featured Content', 'clean-business' ),
) );

$wp_customize->add_section( 'clean_business_featured_content', array(
	'panel'			=> 'clean_business_featured_content',
	'title'			=> esc_html__( 'Featured Content Options', 'clean-business' ),
) );


$wp_customize->add_setting( 'featured_content_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_option'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'featured_content_option', array(
	'choices'  => clean_business_featured_slider_content_options(),
	'label'    => esc_html__( 'Enable Featured Content on', 'clean-business' ),
	'priority' => '1',
	'section'  => 'clean_business_featured_content',
	'settings' => 'featured_content_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_content_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_layout'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'featured_content_layout', array(
	'active_callback' => 'clean_business_is_featured_content_active',
	'choices'         => clean_business_featured_content_layout_options(),
	'label'           => esc_html__( 'Select Featured Content Layout', 'clean-business' ),
	'priority'        => '2',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_layout',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_content_position', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_position'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox'
) );

$wp_customize->add_control( 'featured_content_position', array(
	'active_callback' => 'clean_business_is_featured_content_active',
	'label'           => esc_html__( 'Check to Move above Footer', 'clean-business' ),
	'priority'        => '3',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_position',
	'type'            => 'checkbox',
) );

$wp_customize->add_setting( 'featured_content_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_type'],
	'sanitize_callback'	=> 'sanitize_key',
) );

$wp_customize->add_control( 'featured_content_type', array(
	'active_callback' => 'clean_business_is_featured_content_active',
	'choices'         => clean_business_featured_content_types(),
	'label'           => esc_html__( 'Select Content Type', 'clean-business' ),
	'priority'        => '3',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_content_headline', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_headline'],
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'featured_content_headline' , array(
	'active_callback' => 'clean_business_is_featured_content_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Headline', 'clean-business' ),
	'label'           => esc_html__( 'Headline for Featured Content', 'clean-business' ),
	'priority'        => '4',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_headline',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'featured_content_subheadline', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_subheadline'],
	'sanitize_callback'	=> 'wp_kses_post',
) );

$wp_customize->add_control( 'featured_content_subheadline' , array(
	'active_callback' => 'clean_business_is_featured_content_active',
	'description'     => esc_html__( 'Leave field empty if you want to remove Sub-headline', 'clean-business' ),
	'label'           => esc_html__( 'Sub-headline for Featured Content', 'clean-business' ),
	'priority'        => '5',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_subheadline',
	'type'            => 'text',
	)
);

$wp_customize->add_setting( 'featured_content_number', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_number'],
	'sanitize_callback'	=> 'clean_business_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_content_number' , array(
		'active_callback' => 'clean_business_is_demo_featured_content_inactive',
		'description'     => esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'clean-business' ),
		'input_attrs'     => array(
			'style' => 'width: 45px;',
			'min'   => 0,
			'max'   => 20,
			'step'  => 1,
		),
		'label'           => esc_html__( 'No of Featured Content', 'clean-business' ),
		'priority'        => '6',
		'section'         => 'clean_business_featured_content',
		'settings'        => 'featured_content_number',
		'type'            => 'number',
	)
);

$wp_customize->add_setting( 'featured_content_show', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_show'],
	'sanitize_callback'	=> 'sanitize_key',
) );

$wp_customize->add_control( 'featured_content_show', array(
	'active_callback' => 'clean_business_is_demo_featured_content_inactive',
	'choices'         => clean_business_featured_content_show(),
	'label'           => esc_html__( 'Display Content', 'clean-business' ),
	'priority'        => '6.1',
	'section'         => 'clean_business_featured_content',
	'settings'        => 'featured_content_show',
	'type'            => 'select',
) );


$featured_content_number = apply_filters( 'clean_business_get_option', 'featured_content_number' );

//loop for featured post content
for ( $i=1; $i <=  $featured_content_number ; $i++ ) {
	$wp_customize->add_setting( 'featured_content_page_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'clean_business_sanitize_page',
	) );

	$wp_customize->add_control( 'clean_business_featured_content_page_'. $i, array(
		'active_callback' => 'clean_business_is_featured_page_content_active',
		'label'           => esc_html__( 'Featured Page', 'clean-business' ) . ' ' . $i ,
		'priority'        => '5' . $i,
		'section'         => 'clean_business_featured_content',
		'settings'        => 'featured_content_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}

$wp_customize->add_section( 'clean_business_featured_content_bg_settings', array(
	'description' => esc_html__( 'Make sure Featured Content is enabled for these options to work', 'clean-business' ),
	'panel'       => 'clean_business_featured_content',
	'title'       => esc_html__( 'Featured Content Background Settings', 'clean-business' ),
) );

$wp_customize->add_setting( 'featured_content_bg_image', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_content_bg_image'],
	'sanitize_callback'	=> 'esc_url_raw',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'featured_content_bg_image', array(
	'label'		=> esc_html__( 'Select/Add Background Image', 'clean-business' ),
	'section'   => 'clean_business_featured_content_bg_settings',
    'settings'  => 'featured_content_bg_image',
) ) );
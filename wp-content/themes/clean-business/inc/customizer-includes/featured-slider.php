<?php
/**
 * The template for adding Featured Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */


// Featured Slider
$wp_customize->add_section( 'clean_business_featured_slider', array(
	'priority' => 500,
	'title'    => esc_html__( 'Featured Slider', 'clean-business' ),
) );

$wp_customize->add_setting( 'featured_slider_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_option'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'featured_slider_option', array(
	'choices'  => clean_business_featured_slider_content_options(),
	'label'    => esc_html__( 'Enable Slider on', 'clean-business' ),
	'priority' => '1.1',
	'section'  => 'clean_business_featured_slider',
	'settings' => 'featured_slider_option',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_slider_transition_effect', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_transition_effect'],
	'sanitize_callback'	=> 'clean_business_sanitize_select',
) );

$wp_customize->add_control( 'featured_slider_transition_effect' , array(
		'active_callback' => 'clean_business_is_slider_active',
		'choices'         => clean_business_featured_slider_transition_effects(),
		'label'           => esc_html__( 'Transition Effect', 'clean-business' ),
		'priority'        => '2',
		'section'         => 'clean_business_featured_slider',
		'settings'        => 'featured_slider_transition_effect',
		'type'            => 'select',
	)
);

$wp_customize->add_setting( 'featured_slider_speed', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_speed'],
	'sanitize_callback'	=> 'clean_business_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_slider_speed' , array(
	'active_callback' => 'clean_business_is_slider_active',
	'description'     => esc_html__( 'seconds(s)', 'clean-business' ),
	'input_attrs'     => array(
        'min'   => 1,
        'style' => 'width: 60px;'
	),
	'label'           => esc_html__( 'Speed of the slideshow cycling', 'clean-business' ),
	'priority'        => '2.1.1',
	'section'         => 'clean_business_featured_slider',
	'settings'        => 'featured_slider_speed',
	'type'            => 'number',
	)
);

$wp_customize->add_setting( 'featured_slider_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_type'],
	'sanitize_callback'	=> 'sanitize_key',
) );

$wp_customize->add_control( 'featured_slider_type', array(
	'active_callback' => 'clean_business_is_slider_active',
	'choices'         => clean_business_featured_slider_types(),
	'label'           => esc_html__( 'Select Slider Type', 'clean-business' ),
	'priority'        => '2.1.3',
	'section'         => 'clean_business_featured_slider',
	'settings'        => 'featured_slider_type',
	'type'            => 'select',
) );

$wp_customize->add_setting( 'featured_slider_number', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_slider_number'],
	'sanitize_callback'	=> 'clean_business_sanitize_number_range',
) );

$wp_customize->add_control( 'featured_slider_number' , array(
	'active_callback'	=> 'clean_business_is_demo_slider_inactive',
	'description'	=> esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'clean-business' ),
	'input_attrs' 	=> array(
        'style' => 'width: 45px;',
        'min'   => 0,
        'max'   => 20,
        'step'  => 1,
    	),
	'label'    		=> esc_html__( 'No of Slides', 'clean-business' ),
	'priority'		=> '2.1.4',
	'section'  		=> 'clean_business_featured_slider',
	'settings' 		=> 'featured_slider_number',
	'type'	   		=> 'number',
	)
);

$featured_slider_number = apply_filters( 'clean_business_get_option', 'featured_slider_number' );

//loop for featured post sliders
$priority	=	'11';
for ( $i=1; $i <=  $featured_slider_number ; $i++ ) {
	$wp_customize->add_setting( 'featured_slider_page_'. $i, array(
		'capability'		=> 'edit_theme_options',
		'sanitize_callback'	=> 'clean_business_sanitize_page',
	) );

	$wp_customize->add_control( 'featured_slider_page_'. $i, array(
		'active_callback' => 'clean_business_is_page_slider_active',
		'label'           => esc_html__( 'Featured Page', 'clean-business' ) . ' # ' . $i ,
		'priority'        => '4' . $i,
		'section'         => 'clean_business_featured_slider',
		'settings'        => 'featured_slider_page_'. $i,
		'type'            => 'dropdown-pages',
	) );
}
// Featured Slider End
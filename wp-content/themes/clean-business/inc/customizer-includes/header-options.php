<?php
/**
 * The template for adding Additional Header Option in Customizer
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

// Header Options
$wp_customize->add_setting( 'enable_featured_header_image', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['enable_featured_header_image'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'enable_featured_header_image', array(
	'choices'  => clean_business_enable_featured_header_image_options(),
	'label'    => esc_html__( 'Enable Featured Header Image on ', 'clean-business' ),
	'section'  => 'header_image',
	'settings' => 'enable_featured_header_image',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_image_size', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_image_size'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'featured_image_size', array(
	'choices'  => clean_business_featured_image_size_options(),
	'label'    => esc_html__( 'Page/Post Featured Header Image Size', 'clean-business' ),
	'section'  => 'header_image',
	'settings' => 'featured_image_size',
	'type'     => 'select',
) );

$wp_customize->add_setting( 'featured_header_image_alt', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_image_alt'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'featured_header_image_alt', array(
	'label'    => esc_html__( 'Featured Header Image Alt/Title Tag ', 'clean-business' ),
	'section'  => 'header_image',
	'settings' => 'featured_header_image_alt',
	'type'     => 'text',
) );

$wp_customize->add_setting( 'featured_header_image_url', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['featured_header_image_url'],
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'featured_header_image_url', array(
	'label'    => esc_html__( 'Featured Header Image Link URL', 'clean-business' ),
	'section'  => 'header_image',
	'settings' => 'featured_header_image_url',
	'type'     => 'text',
) );

$wp_customize->add_setting( 'featured_header_image_base', array(
	'capability'        => 'edit_theme_options',
	'default'           => $defaults['featured_header_image_url'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox',
) );

$wp_customize->add_control( 'featured_header_image_base', array(
	'label'    => esc_html__( 'Check to Open Link in New Window/Tab', 'clean-business' ),
	'section'  => 'header_image',
	'settings' => 'featured_header_image_base',
	'type'     => 'checkbox',
) );
// Header Options End
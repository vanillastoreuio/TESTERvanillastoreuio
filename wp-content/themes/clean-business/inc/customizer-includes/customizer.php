<?php
/**
 * The main template for implementing Theme/Customzer Options
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */


/**
 * Implements clean-business theme options into Theme Customizer.
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since Clean Business 0.1
 */
function clean_business_customize_register( $wp_customize ) {
	$defaults = clean_business_get_default_theme_options();

	//Custom Controls
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/custom-controls.php';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_setting( 'hide_tagline', array(
		'default'			=> $defaults['hide_tagline'],
		'sanitize_callback' => 'clean_business_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'hide_tagline', array(
		'label'    => esc_html__( 'Check to Hide Site Description/Tagline', 'clean-business' ),
		'priority' => 50,
		'section'  => 'title_tagline',
		'settings' => 'hide_tagline',
		'type'     => 'checkbox',
	) );

	$wp_customize->add_setting( 'move_title_tagline', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['move_title_tagline'],
		'sanitize_callback' => 'clean_business_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'move_title_tagline', array(
		'label'    => esc_html__( 'Check to move Site Title and Tagline before logo', 'clean-business' ),
		'priority' => function_exists( 'has_custom_logo' ) ? 10 : 103,
		'section'  => 'title_tagline',
		'settings' => 'move_title_tagline',
		'type'     => 'checkbox',
	) );
	// Custom Logo End

	// Header Options (added to Header section in Theme Customizer)
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/header-options.php';

	//Theme Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/theme-options.php';

	// Color Options
	$wp_customize->add_setting( 'color_scheme', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback'	=> 'sanitize_key'
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'choices'  => clean_business_color_schemes(),
		'label'    => esc_html__( 'Color Scheme', 'clean-business' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'color_scheme',
		'type'     => 'radio',
	) );

	//Featured Content Setting
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-content.php';

	//Featured Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/featured-slider.php';

	//Social Links
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/social-icons.php';

	// Reset all settings to default
	$wp_customize->add_section( 'clean_business_reset_all_settings', array(
		'description'	=> esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'clean-business' ),
		'priority' 		=> 700,
		'title'  		=> esc_html__( 'Reset all settings', 'clean-business' ),
	) );

	$wp_customize->add_setting( 'reset_all_settings', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'clean_business_sanitize_checkbox',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'reset_all_settings', array(
		'label'  => esc_html__( 'Check to reset all settings to default', 'clean-business' ),
		'section' => 'clean_business_reset_all_settings',
		'settings' => 'reset_all_settings',
		'type'   => 'checkbox',
	) );
	// Reset all settings to default end


	//Important Links
		$wp_customize->add_section( 'important_links', array(
			'priority' 		=> 999,
			'title'  	 	=> esc_html__( 'Important Links', 'clean-business' ),
		) );

		/**
		 * Has dummy Sanitizaition function as it contains no value to be sanitized
		 */
		$wp_customize->add_setting( 'important_links', array(
			'sanitize_callback'	=> 'clean_business_sanitize_important_link',
		) );

		$wp_customize->add_control( new clean_business_important_links( $wp_customize, 'important_links', array(
	    'label'  	=> esc_html__( 'Important Links', 'clean-business' ),
	     'section' 	=> 'important_links',
	    'settings' 	=> 'important_links',
	    'type'   	=> 'important_links',
	  ) ) );
	  //Important Links End
}
add_action( 'customize_register', 'clean_business_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously for clean-business.
 * And flushes out all transient data on preview
 *
 * @since Clean Business 0.1
 */
function clean_business_customize_preview() {
	wp_enqueue_script( 'clean_business_customizer', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer.js', array( 'customize-preview' ), '20120827', true );

	//Flush transients
	clean_business_flush_transients();
}
add_action( 'customize_preview_init', 'clean_business_customize_preview' );


/**
 * Custom scripts and styles on customize.php for clean-business.
 *
 * @since Clean Business 0.1
 */
function clean_business_customize_scripts() {
	wp_enqueue_script( 'clean_business_customizer_custom', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer-custom-script.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20160620', true );


	$clean_business_misc_links['color_list'] = clean_business_color_list();

	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'clean_business_customizer_custom', 'clean_business_misc_links', $clean_business_misc_links );
}
add_action( 'customize_controls_enqueue_scripts', 'clean_business_customize_scripts');


/**
 * Returns list of color keys of array with default values for each color scheme as index
 *
 * @since Clean Business 3.1
 */
function clean_business_color_list() {
	// Get default color scheme values
	$default      = clean_business_get_default_theme_options();

	// Get default dark color scheme valies
	$default_dark = clean_business_default_dark_color_options();

	$color_list['background_color']['light'] = $default['background_color'];
	$color_list['background_color']['dark']  = $default_dark['background_color'];

	$color_list['header_textcolor']['light'] = $default['header_textcolor'];
	$color_list['header_textcolor']['dark']  = $default_dark['header_textcolor'];

	return $color_list;
}

/**
 * Function to reset date with respect to condition
 */
function clean_business_reset_data() {
	if ( get_theme_mod( 'reset_all_settings' ) ) {
    	remove_theme_mods();

        // Flush out all transients	on reset
        clean_business_flush_transients();

        return;
    }
}
add_action( 'customize_save_after', 'clean_business_reset_data' );


//Active callbacks for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/active-callbacks.php';


//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/sanitize-functions.php';

//Add upgrade to pro button
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/upgrade-button/class-customize.php';

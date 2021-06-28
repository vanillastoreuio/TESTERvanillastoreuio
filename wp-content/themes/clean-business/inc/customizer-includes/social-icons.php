<?php
/**
 * The template for Social Links in Customizer
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

// Social Icons
$wp_customize->add_section( 'clean_business_social_links', array(
	'priority' => 700,
	'title'    => esc_html__( 'Social Links', 'clean-business' ),
) );

$clean_business_social_icons 	=	clean_business_get_social_icons_list();

foreach ( $clean_business_social_icons as $key => $value ){
	if( 'skype_link' == $key ){
		$wp_customize->add_setting( $key, array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback' => 'esc_attr',
			) );

		$wp_customize->add_control( $key, array(
			'description'	=> esc_html__( 'Skype link can be of formats: callto://+{number} or skype:{username}?{action}. More Information in readme file', 'clean-business' ),
			'label'    		=> $value['label'],
			'section'  		=> 'clean_business_social_links',
			'settings' 		=> $key,
			'type'	   		=> 'url',
		) );
	}
	else {
		if( 'email_link' == $key ){
			$wp_customize->add_setting( $key, array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'sanitize_email',
				) );
		}
		else if( 'handset_link' == $key || 'phone_link' == $key ){
			$wp_customize->add_setting( $key, array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				) );
		}
		else {
			$wp_customize->add_setting( $key, array(
					'capability'		=> 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				) );
		}

		$wp_customize->add_control( $key, array(
			'label'    => $value['label'],
			'section'  => 'clean_business_social_links',
			'settings' => $key,
			'type'	   => 'url',
		) );
	}
}
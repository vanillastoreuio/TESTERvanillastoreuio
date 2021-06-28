<?php
/**
 * The template for adding additional theme options in Customizer
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

//Theme Options
$wp_customize->add_panel( 'clean_business_theme_options', array(
    'description'    => esc_html__( 'Basic theme Options', 'clean-business' ),
    'capability'     => 'edit_theme_options',
    'priority'       => 200,
    'title'    		 => esc_html__( 'Theme Options', 'clean-business' ),
) );

// Breadcrumb Option
$wp_customize->add_section( 'clean_business_breadcrumb_options', array(
	'description'	=> esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'clean-business' ),
	'panel'			=> 'clean_business_theme_options',
	'title'    		=> esc_html__( 'Breadcrumb Options', 'clean-business' ),
	'priority' 		=> 201,
) );

$wp_customize->add_setting( 'breadcrumb_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_option'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_option', array(
	'label'    => esc_html__( 'Check to Enable Breadcrumb', 'clean-business' ),
	'section'  => 'clean_business_breadcrumb_options',
	'settings' => 'breadcrumb_option',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_onhomepage', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_onhomepage'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_onhomepage', array(
	'label'    => esc_html__( 'Check to enable Breadcrumb on Homepage', 'clean-business' ),
	'section'  => 'clean_business_breadcrumb_options',
	'settings' => 'breadcrumb_onhomepage',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_seperator', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_seperator'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'breadcrumb_seperator', array(
	'input_attrs' => array(
    		'style' => 'width: 40px;'
		),
	'label'    	=> esc_html__( 'Separator between Breadcrumbs', 'clean-business' ),
	'section' 	=> 'clean_business_breadcrumb_options',
	'settings' 	=> 'breadcrumb_seperator',
	'type'     	=> 'text'
	)
);
// Breadcrumb Option End

/**
 * Do not show Custom CSS option from WordPress 4.7 onwards
 * @remove when WP 5.0 is released
 */
if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
	// Custom CSS Option
	$wp_customize->add_section( 'clean_business_custom_css', array(
		'description'	=> esc_html__( 'Custom/Inline CSS', 'clean-business'),
		'panel'  		=> 'clean_business_theme_options',
		'priority' 		=> 203,
		'title'    		=> esc_html__( 'Custom CSS Options', 'clean-business' ),
	) );

	$wp_customize->add_setting( 'custom_css', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['custom_css'],
		'sanitize_callback' => 'clean_business_sanitize_custom_css',
	) );

	$wp_customize->add_control( 'custom_css', array(
			'label'		=> esc_html__( 'Enter Custom CSS', 'clean-business' ),
	        'priority'	=> 1,
			'section'   => 'clean_business_custom_css',
	        'settings'  => 'custom_css',
			'type'		=> 'textarea',
	) );
	// Custom CSS End
}

	// Excerpt Options
$wp_customize->add_section( 'clean_business_excerpt_options', array(
	'panel'  	=> 'clean_business_theme_options',
	'priority' 	=> 204,
	'title'    	=> esc_html__( 'Excerpt Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'excerpt_length', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_length'],
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'excerpt_length', array(
	'description' => esc_html__('Excerpt length. Default is 55 words', 'clean-business'),
	'input_attrs' => array(
        'min'   => 10,
        'max'   => 200,
        'step'  => 5,
        'style' => 'width: 60px;'
        ),
    'label'    => esc_html__( 'Excerpt Length (words)', 'clean-business' ),
	'section'  => 'clean_business_excerpt_options',
	'settings' => 'excerpt_length',
	'type'	   => 'number',
	)
);

$wp_customize->add_setting( 'excerpt_more_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_more_text'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'excerpt_more_text', array(
	'label'    => esc_html__( 'Read More Text', 'clean-business' ),
	'section'  => 'clean_business_excerpt_options',
	'settings' => 'excerpt_more_text',
	'type'	   => 'text',
) );
// Excerpt Options End

//Homepage / Frontpage Options
$wp_customize->add_section( 'clean_business_homepage_options', array(
	'description'	=> esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'clean-business' ),
	'panel'			=> 'clean_business_theme_options',
	'priority' 		=> 209,
	'title'   	 	=> esc_html__( 'Homepage / Frontpage Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'front_page_category', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['front_page_category'],
	'sanitize_callback'	=> 'clean_business_sanitize_category_list',
) );

$wp_customize->add_control( new clean_business_customize_dropdown_categories_control( $wp_customize, 'front_page_category', array(
    'label'   	=> esc_html__( 'Select Categories', 'clean-business' ),
    'name'	 	=> 'front_page_category',
	'priority'	=> '6',
    'section'  	=> 'clean_business_homepage_options',
    'settings' 	=> 'front_page_category',
    'type'     	=> 'dropdown-categories',
) ) );
//Homepage / Frontpage Settings End

// Layout Options
$wp_customize->add_section( 'clean_business_layout', array(
	'capability'=> 'edit_theme_options',
	'panel'		=> 'clean_business_theme_options',
	'priority'	=> 211,
	'title'		=> esc_html__( 'Layout Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'theme_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['theme_layout'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'theme_layout', array(
	'choices'	=> clean_business_layouts(),
	'label'		=> esc_html__( 'Default Layout', 'clean-business' ),
	'section'	=> 'clean_business_layout',
	'settings'   => 'theme_layout',
	'type'		=> 'select',
) );

$wp_customize->add_setting( 'content_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['content_layout'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'content_layout', array(
	'choices'   => clean_business_get_archive_content_layout(),
	'label'		=> esc_html__( 'Archive Content Layout', 'clean-business' ),
	'section'   => 'clean_business_layout',
	'settings'  => 'content_layout',
	'type'      => 'select',
) );

$wp_customize->add_setting( 'single_post_image_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['single_post_image_layout'],
	'sanitize_callback' => 'sanitize_key',
) );


$wp_customize->add_control( 'single_post_image_layout', array(
		'label'		=> esc_html__( 'Single Page/Post Image Layout ', 'clean-business' ),
		'section'   => 'clean_business_layout',
        'settings'  => 'single_post_image_layout',
        'type'	  	=> 'select',
		'choices'  	=> clean_business_single_post_image_layout_options()
) );
	// Layout Options End

// Pagination Options
$pagination_type = apply_filters( 'clean_business_get_option', 'pagination_type' );

$navigation_description = sprintf(
	wp_kses(
		__( '<a target="_blank" href="%1$s">WP-PageNavi Plugin</a> is recommended for Numeric Option(But will work without it).<br/>Infinite Scroll Options requires <a target="_blank" href="%2$s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'clean-business' ),
		array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
			'br'=> array()
		)
	),
	esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ),
	esc_url( 'https://wordpress.org/plugins/jetpack/' )
);

/**
* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
*/
if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) ) {
	if ( ! (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
		$navigation_description = sprintf(
			wp_kses(
				__( 'Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'clean-business' ),
				array(
					'a' => array(
						'href' => array(),
						'target' => array()
					)
				)
			),
			esc_url( 'https://wordpress.org/plugins/jetpack/' )
		);
	}
	else {
		$navigation_description = '';
	}
}

$wp_customize->add_section( 'clean_business_pagination_options', array(
	'description'	=> $navigation_description,
	'panel'  		=> 'clean_business_theme_options',
	'priority'		=> 212,
	'title'    		=> esc_html__( 'Pagination Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'pagination_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['pagination_type'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'pagination_type', array(
	'choices'  => clean_business_get_pagination_types(),
	'label'    => esc_html__( 'Pagination type', 'clean-business' ),
	'section'  => 'clean_business_pagination_options',
	'settings' => 'pagination_type',
	'type'	   => 'select',
) );
// Pagination Options End

//Promotion Headline Options
$wp_customize->add_section( 'clean_business_promotion_headline_options', array(
	'description'	=> esc_html__( 'To disable the fields, simply leave them empty.', 'clean-business' ),
	'panel'			=> 'clean_business_theme_options',
	'priority' 		=> 213,
	'title'   	 	=> esc_html__( 'Promotion Headline Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'promotion_headline_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_option'],
	'sanitize_callback' => 'sanitize_key',
) );

$wp_customize->add_control( 'promotion_headline_option', array(
	'choices'  	=> clean_business_featured_slider_content_options(),
	'label'    	=> esc_html__( 'Enable Promotion Headline on', 'clean-business' ),
	'priority'	=> '0.5',
	'section'  	=> 'clean_business_promotion_headline_options',
	'settings' 	=> 'promotion_headline_option',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'promotion_headline', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'promotion_headline', array(
	'description'	=> esc_html__( 'Appropriate Words: 10', 'clean-business' ),
	'label'    	=> esc_html__( 'Promotion Headline Text', 'clean-business' ),
	'priority'	=> '1',
	'section' 	=> 'clean_business_promotion_headline_options',
	'settings'	=> 'promotion_headline',
) );

$wp_customize->add_setting( 'promotion_subheadline', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_subheadline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'promotion_subheadline', array(
	'description'	=> esc_html__( 'Appropriate Words: 15', 'clean-business' ),
	'label'    	=> esc_html__( 'Promotion Subheadline Text', 'clean-business' ),
	'priority'	=> '2',
	'section' 	=> 'clean_business_promotion_headline_options',
	'settings'	=> 'promotion_subheadline',
) );

$wp_customize->add_setting( 'promotion_headline_button', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_button'],
	'sanitize_callback'	=> 'sanitize_text_field'
) );

$wp_customize->add_control( 'promotion_headline_button', array(
	'description'	=> esc_html__( 'Appropriate Words: 3', 'clean-business' ),
	'label'    	=> esc_html__( 'Promotion Headline Button Text ', 'clean-business' ),
	'priority'	=> '3',
	'section' 	=> 'clean_business_promotion_headline_options',
	'settings'	=> 'promotion_headline_button',
	'type'		=> 'text',
) );

$wp_customize->add_setting( 'promotion_headline_url', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_url'],
	'sanitize_callback'	=> 'esc_url_raw'
) );

$wp_customize->add_control( 'promotion_headline_url', array(
	'label'    	=> esc_html__( 'Promotion Headline Link', 'clean-business' ),
	'priority'	=> '4',
	'section' 	=> 'clean_business_promotion_headline_options',
	'settings'	=> 'promotion_headline_url',
	'type'		=> 'text',
) );

$wp_customize->add_setting( 'promotion_headline_target', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_target'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox',
) );

$wp_customize->add_control( 'promotion_headline_target', array(
	'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'clean-business' ),
	'priority'	=> '5',
	'section'  	=> 'clean_business_promotion_headline_options',
	'settings' 	=> 'promotion_headline_target',
	'type'     	=> 'checkbox',
) );
// Promotion Headline Options End

// Scrollup
$wp_customize->add_section( 'clean_business_scrollup', array(
	'panel'    => 'clean_business_theme_options',
	'priority' => 215,
	'title'    => esc_html__( 'Scrollup Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'disable_scrollup', array(
	'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['disable_scrollup'],
	'sanitize_callback' => 'clean_business_sanitize_checkbox',
) );

$wp_customize->add_control( 'disable_scrollup', array(
	'label'		=> esc_html__( 'Check to disable Scroll Up', 'clean-business' ),
	'section'   => 'clean_business_scrollup',
    'settings'  => 'disable_scrollup',
	'type'		=> 'checkbox',
) );
// Scrollup End

// Search Options
$wp_customize->add_section( 'clean_business_search_options', array(
	'description'=> esc_html__( 'Change default placeholder text in Search.', 'clean-business'),
	'panel'  => 'clean_business_theme_options',
	'priority' => 216,
	'title'    => esc_html__( 'Search Options', 'clean-business' ),
) );

$wp_customize->add_setting( 'search_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['search_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'search_text', array(
	'label'		=> esc_html__( 'Default Display Text in Search', 'clean-business' ),
	'section'   => 'clean_business_search_options',
    'settings'  => 'search_text',
	'type'		=> 'text',
) );
// Search Options End
//Theme Option End
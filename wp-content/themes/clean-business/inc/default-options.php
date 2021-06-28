<?php
/**
 * Implement Default Theme/Customizer Options
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */


/**
 * Returns the default options for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_get_default_theme_options( $parameter = null ) {
	$theme_data = wp_get_theme();

	$default_theme_options = array(
		//Site Title an Tagline
		'hide_tagline'                                     => 1,
		'move_title_tagline'                               => 0,

		//Layout
		'theme_layout'                                     => 'right-sidebar',
		'content_layout'                                   => 'excerpt-image-top',
		'single_post_image_layout'                         => 'disabled',

		//Header Image
		'enable_featured_header_image'                     => 'exclude-homepage',
		'featured_image_size'                              => 'full',
		'featured_header_image_url'                        => '',
		'featured_header_image_alt'                        => '',
		'featured_header_image_base'                       => 0,

		//Breadcrumb Options
		'breadcrumb_option'                                => 0,
		'breadcrumb_onhomepage'                            => 0,
		'breadcrumb_seperator'                             => '&raquo;',

		//Custom CSS
		'custom_css'                                       => '',

		//Scrollup Options
		'disable_scrollup'                                 => 0,

		//Excerpt Options
		'excerpt_length'                                   => '55',
		'excerpt_more_text'                                => esc_html__( 'Read More ...', 'clean-business' ),

		//Homepage / Frontpage Settings
		'front_page_category'                              => '0',

		//Pagination Options
		'pagination_type'                                  => 'default',

		//Promotion Headline Options
		'promotion_headline_option'                        => 'disabled',
		'promotion_headline'                               => esc_html__( 'Clean Business is a Responsive WordPress Theme', 'clean-business' ),
		'promotion_subheadline'                            => esc_html__( 'This is promotion headline. You can edit this from Appearance -> Customize -> Theme Options -> Promotion Headline Options', 'clean-business' ),
		'promotion_headline_button'                        => esc_html__( 'Buy Now', 'clean-business' ),
		'promotion_headline_url'                           => '#',
		'promotion_headline_target'                        => 1,

		//Search Options
		'search_text'                                      => esc_html__( 'Search...', 'clean-business' ),

		//Basic Color Options
		'color_scheme'                                     => 'light',
		'background_color'                                 => '#f9f9f9',
		'header_textcolor'                                 => '#ffffff',

		//Featured Content Options
		'featured_content_option'                          => 'disabled',
		'featured_content_layout'                          => 'layout-four',
		'featured_content_position'                        => 0,
		'featured_content_headline'                        => '',
		'featured_content_subheadline'                     => '',
		'featured_content_type'                            => 'demo-featured-content',
		'featured_content_number'                          => '3',
		'featured_content_show'                            => 'excerpt',
		'featured_content_bg_image'                        => trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/default_bg.jpg',

		//Featured Slider Options
		'featured_slider_option'                           => 'disabled',
		'featured_slider_image_loader'                     => 'true',
		'featured_slider_transition_effect'                => 'fade',
		'featured_slider_speed'                            => '4',
		'featured_slider_type'                             => 'demo-featured-slider',
		'featured_slider_number'                           => '4',

		//Reset all settings
		'reset_all_settings'                               => 0,
	);

	if ( null == $parameter ) {
		return apply_filters( 'clean_business_default_theme_options', $default_theme_options );
	}
	else {
		if ( isset( $default_theme_options[ $parameter ] ) ) {
			return $default_theme_options[ $parameter ];
		};

		return false;
	}
}


/**
 * Returns the default options for Clean Business dark theme.
 *
 * @since Catchresponsive 1.0
 */
function clean_business_default_dark_color_options() {
	$default_dark_color_options = array(
		//Basic Color Options
		'background_color'                                 => '#333333',
		'header_textcolor'                                 => '#ffffff',
	);

	return apply_filters( 'clean_business_default_dark_color_options', $default_dark_color_options );
}

/**
 * Returns an array of color schemes registered for Clean Business.
 *
 * @since Clean Business 0.1
 */
function clean_business_color_schemes() {
	$options= array(
		'light'    => esc_html__( 'Light', 'clean-business' ),
		'dark'     => esc_html__( 'Dark', 'clean-business' ),
	);

	return apply_filters( 'clean_business_color_schemes', $options );
}

/**
 * Returns an array of feature header enable options
 *
 * @since Clean Business 0.1
 */
function clean_business_enable_featured_header_image_options() {
	$options = array(
		'homepage'               => esc_html__( 'Homepage / Frontpage', 'clean-business' ),
		'exclude-homepage'       => esc_html__( 'Excluding Homepage', 'clean-business' ),
		'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'clean-business' ),
		'entire-site'            => esc_html__( 'Entire Site', 'clean-business' ),
		'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'clean-business' ),
		'pages-posts'            => esc_html__( 'Pages and Posts', 'clean-business' ),
		'disabled'               => esc_html__( 'Disabled', 'clean-business' ),
	);

	return apply_filters( 'clean_business_enable_featured_header_image_options', $options );
}

/**
 * Returns an array of layout options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_layouts() {
	$options = array(
		'left-sidebar'  => esc_html__( 'Primary Sidebar, Content', 'clean-business' ),
		'right-sidebar' => esc_html__( 'Content, Primary Sidebar', 'clean-business' ),
		'no-sidebar'    => esc_html__( 'No Sidebar ( Content Width )', 'clean-business' ),
	);
	return apply_filters( 'clean_business_layouts', $options );
}

/**
 * Returns an array of content layout options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_get_archive_content_layout() {
	$options = array(
		'excerpt-image-left'  => esc_html__( 'Excerpt Image Left', 'clean-business' ),
		'excerpt-image-right' => esc_html__( 'Excerpt Image Right', 'clean-business' ),
		'excerpt-image-top'   => esc_html__( 'Excerpt Image Top', 'clean-business' ),
		'full-content'        => esc_html__( 'Show Full Content (No Featured Image)', 'clean-business' ),
	);

	return apply_filters( 'clean_business_get_archive_content_layout', $options );
}


/**
 * Returns an array of feature image size
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_image_size_options() {
	$all_sizes = clean_business_get_additional_image_sizes();

	foreach ($all_sizes as $key => $value) {
		$options[$key] = esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')';
	}

	$options['full']     = esc_html__( 'Full size', 'clean-business' );

	return apply_filters( 'clean_business_featured_image_size_options', $options );
}


/**
 * Returns an array of pagination schemes registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_get_pagination_types() {
	$options = array(
		'default'                => esc_html__( 'Default(Older Posts/Newer Posts)', 'clean-business' ),
		'numeric'                => esc_html__( 'Numeric', 'clean-business' ),
		'infinite-scroll-click'  => esc_html__( 'Infinite Scroll (Click)', 'clean-business' ),
		'infinite-scroll-scroll' => esc_html__( 'Infinite Scroll (Scroll)', 'clean-business' ),
	);

	return apply_filters( 'clean_business_get_pagination_types', $options );
}


/**
 * Returns an array of content featured image size.
 *
 * @since Clean Business 0.1
 */
function clean_business_single_post_image_layout_options() {
	$all_sizes = clean_business_get_additional_image_sizes();

	foreach ($all_sizes as $key => $value) {
		$options[$key] = esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')';
	}

	$options['disabled'] = esc_html__( 'Disabled', 'clean-business' );
	$options['full']     = esc_html__( 'Full size', 'clean-business' );

	return apply_filters( 'clean_business_single_post_image_layout_options', $options );
}

/**
 * Returns an array of metabox layout options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_metabox_layouts() {
	$options = array(
		'default' 	=> array(
			'id' 	=> 'clean-business-layout-option',
			'value' => 'default',
			'label' => esc_html__( 'Default', 'clean-business' ),
		),
		'left-sidebar' 	=> array(
			'id' 	=> 'clean-business-layout-option',
			'value' => 'left-sidebar',
			'label' => esc_html__( 'Primary Sidebar, Content', 'clean-business' ),
		),
		'right-sidebar' => array(
			'id' 	=> 'clean-business-layout-option',
			'value' => 'right-sidebar',
			'label' => esc_html__( 'Content, Primary Sidebar', 'clean-business' ),
		),
		'no-sidebar'	=> array(
			'id' 	=> 'clean-business-layout-option',
			'value' => 'no-sidebar',
			'label' => esc_html__( 'No Sidebar ( Content Width )', 'clean-business' ),
		)
	);
	return apply_filters( 'clean_business_layouts', $options );
}

/**
 * Returns an array of metabox header featured image options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_metabox_header_featured_image_options() {
	$options = array(
		'default' => array(
			'id'		=> 'clean-business-header-image',
			'value' 	=> 'default',
			'label' 	=> esc_html__( 'Default', 'clean-business' ),
		),
		'enable' => array(
			'id'		=> 'clean-business-header-image',
			'value' 	=> 'enable',
			'label' 	=> esc_html__( 'Enable', 'clean-business' ),
		),
		'disabled' => array(
			'id'		=> 'clean-business-header-image',
			'value' 	=> 'disabled',
			'label' 	=> esc_html__( 'Disable', 'clean-business' )
		)
	);
	return apply_filters( 'header_featured_image_options', $options );
}


/**
 * Returns an array of metabox featured image options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_metabox_featured_image_options() {
	$options['default'] = array(
		'id'	=> 'clean-business-featured-image',
		'value' => 'default',
		'label' => esc_html__( 'Default', 'clean-business' ),
	);

	$all_sizes = clean_business_get_additional_image_sizes();

	foreach ( $all_sizes as $key => $value ) {
		$options[$key] = array(
			'id'	=> 'clean-business-featured-image',
			'value' => $key,
			'label' => esc_html( $key ).' ('.$value['width'].'x'.$value['height'].')'
		);

	}

	$options['full'] = array(
		'id'	=> 'clean-business-featured-image',
		'value'	=> 'full',
		'label' => esc_html__( 'Full Image', 'clean-business' ),
	);

	$options['disabled'] = array(
		'id' 	=> 'clean-business-featured-image',
		'value' => 'disabled',
		'label' => esc_html__( 'Disable Image', 'clean-business' )
	);

	return apply_filters( 'clean_business_single_post_image_layout_options', $options );


	$options = array(
		'default' => array(
			'id'	=> 'clean-business-featured-image',
			'value' => 'default',
			'label' => esc_html__( 'Default', 'clean-business' ),
		),
		'featured-image'		=> array(
			'id'	=> 'clean-business-featured-image',
			'value' => 'featured-image',
			'label' => esc_html__( 'Featured Image', 'clean-business' ),
		),
		'slider'		=> array(
			'id'	=> 'clean-business-featured-image',
			'value' => 'slider',
			'label' => esc_html__( 'Slider', 'clean-business' ),
		),
		'full' 		=> array(
			'id'	=> 'clean-business-featured-image',
			'value'	=> 'full',
			'label' => esc_html__( 'Full Image', 'clean-business' ),
		),
		'disabled' => array(
			'id' 	=> 'clean-business-featured-image',
			'value' => 'disabled',
			'label' => esc_html__( 'Disable Image', 'clean-business' )
		)
	);
	return apply_filters( 'featured_image_options', $options );
}

/**
 * Returns an array of featured content options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_content_layout_options() {
	$options = array(
		'layout-one' 	=> esc_html__( '1 column', 'clean-business' ),
		'layout-two' 	=> esc_html__( '2 columns', 'clean-business' ),
		'layout-three' 	=> esc_html__( '3 columns', 'clean-business' ),
		'layout-four' 	=> esc_html__( '4 columns', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_content_layout_options', $options );
}


/**
 * Returns an array of featured content show registered for fabulous fluid.
 *
 * @since Clean Business 1.1
 */
function clean_business_featured_content_show() {
	$options = array(
		'excerpt' 		=> esc_html__( 'Show Excerpt', 'clean-business' ),
		'full-content' 	=> esc_html__( 'Show Full Content', 'clean-business' ),
		'hide-content' 	=> esc_html__( 'Hide Content', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_content_show', $options );
}


/**
 * Returns an array of feature content types registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_content_types() {
	$options = array(
		'demo-featured-content' => esc_html__( 'Demo', 'clean-business' ),
		'featured-page-content' => esc_html__( 'Page', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_content_types', $options );
}

/**
 * Returns an array of slider layout options registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_slider_options() {
	$options = array(
		'homepage' 		=> esc_html__( 'Homepage / Frontpage', 'clean-business' ),
		'entire-site' 	=> esc_html__( 'Entire Site', 'clean-business' ),
		'disabled'		=> esc_html__( 'Disabled', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_slider_options', $options );
}

/**
 * Returns an array of feature slider types registered for fabulous fluid.
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_slider_types() {
	$options = array(
		'demo-featured-slider' => esc_html__( 'Demo', 'clean-business' ),
		'featured-page-slider' => esc_html__( 'Page', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_slider_types', $options );
}


/**
 * Returns an array of feature slider transition effects
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_slider_transition_effects() {
	$options = array(
		'fade' 		=> esc_html__( 'Fade', 'clean-business' ),
		'slide'	=> esc_html__( 'Slide', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_slider_transition_effects', $options );
}


/**
 * Returns an array of content and slider layout options
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_slider_content_options() {
	$options = array(
		'homepage' 		=> esc_html__( 'Homepage / Frontpage', 'clean-business' ),
		'entire-site' 	=> esc_html__( 'Entire Site', 'clean-business' ),
		'disabled'		=> esc_html__( 'Disabled', 'clean-business' ),
	);

	return apply_filters( 'clean_business_featured_slider_content_options', $options );
}


/**
 * Returns list of social icons currently supported
 *
 * @since Clean Business 0.1
*/
function clean_business_get_social_icons_list() {
	$options = array(
		'facebook_link'    => array(
			'class' => 'facebook',
			'label' => esc_html__( 'Facebook', 'clean-business' )
		),
		'twitter_link'     => array(
			'class' => 'twitter',
			'label' => esc_html__( 'Twitter', 'clean-business' )
		),
		'googleplus_link'  => array(
			'class' => 'google-plus',
			'label' => esc_html__( 'Googleplus', 'clean-business' )
		),
		'email_link'       => array(
			'class' => 'envelope',
			'label' => esc_html__( 'Email', 'clean-business' )
		),
		'feed_link'        => array(
			'class' => 'rss',
			'label' => esc_html__( 'Feed', 'clean-business' )
		),
		'wordpress_link'   => array(
			'class' => 'wordpress',
			'label' => esc_html__( 'WordPress', 'clean-business' )
		),
		'github_link'      => array(
			'class' => 'github',
			'label' => esc_html__( 'GitHub', 'clean-business' )
		),
		'linkedin_link'    => array(
			'class' => 'linkedin',
			'label' => esc_html__( 'LinkedIn', 'clean-business' )
		),
		'pinterest_link'   => array(
			'class' => 'pinterest',
			'label' => esc_html__( 'Pinterest', 'clean-business' )
		),
		'flickr_link'      => array(
			'class' => 'flickr',
			'label' => esc_html__( 'Flickr', 'clean-business' )
		),
		'vimeo_link'       => array(
			'class' => 'vimeo',
			'label' => esc_html__( 'Vimeo', 'clean-business' )
		),
		'youtube_link'     => array(
			'class' => 'youtube',
			'label' => esc_html__( 'YouTube', 'clean-business' )
		),
		'tumblr_link'      => array(
			'class' => 'tumblr',
			'label' => esc_html__( 'Tumblr', 'clean-business' )
		),
		'instagram_link'   => array(
			'class' => 'instagram',
			'label' => esc_html__( 'Instagram', 'clean-business' )
		),
		'codepen_link'     => array(
			'class' => 'codepen',
			'label' => esc_html__( 'CodePen', 'clean-business' )
		),
		'dribbble_link'    => array(
			'class' => 'dribbble',
			'label' => esc_html__( 'Dribbble', 'clean-business' )
		),
		'skype_link'       => array(
			'class' => 'skype',
			'label' => esc_html__( 'Skype', 'clean-business' )
		),
		'digg_link'        => array(
			'class' => 'digg',
			'label' => esc_html__( 'Digg', 'clean-business' )
		),
		'reddit_link'      => array(
			'class' => 'reddit',
			'label' => esc_html__( 'Reddit', 'clean-business' )
		),
		'stumbleupon_link' => array(
			'class' => 'stumbleupon',
			'label' => esc_html__( 'Stumbleupon', 'clean-business' )
		),
		'pocket_link'      => array(
			'class' => 'get-pocket',
			'label' => esc_html__( 'Pocket', 'clean-business' ),
		),
		'dropbox_link'     => array(
			'class' => 'dropbox',
			'label' => esc_html__( 'DropBox', 'clean-business' ),
		),
		'spotify_link'     => array(
			'class' => 'spotify',
			'label' => esc_html__( 'Spotify', 'clean-business' ),
		),
		'foursquare_link'  => array(
			'class' => 'foursquare',
			'label' => esc_html__( 'Foursquare', 'clean-business' ),
		),
		'twitch_link'      => array(
			'class' => 'twitch',
			'label' => esc_html__( 'Twitch', 'clean-business' ),
		),
		'website_link'     => array(
			'class' => 'globe',
			'label' => esc_html__( 'Website', 'clean-business' ),
		),
		'phone_link'       => array(
			'class' => 'mobile',
			'label' => esc_html__( 'Phone', 'clean-business' ),
		),
		'handset_link'     => array(
			'class' => 'phone',
			'label' => esc_html__( 'Handset', 'clean-business' ),
		),
		'cart_link'        => array(
			'class' => 'shopping-cart',
			'label' => esc_html__( 'Cart', 'clean-business' ),
		),
		'cloud_link'       => array(
			'class' => 'cloud',
			'label' => esc_html__( 'Cloud', 'clean-business' ),
		),
		'link_link'        => array(
			'class' => 'link',
			'label' => esc_html__( 'Link', 'clean-business' ),
		),
	);

	return apply_filters( 'clean_business_social_icons_list', $options );
}

/**
 * @since Clean Business 0.1
 */
function clean_business_get_content() {
	$theme_data = wp_get_theme();

	$content['left'] 	= sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL 3: Privacy Policy Link', 'clean-business' ), esc_attr( date_i18n( __( 'Y', 'clean-business' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', get_the_privacy_policy_link() );

	$content['right']	= esc_attr( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'clean-business' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_attr( $theme_data->get( 'Author' ) ) .'</a>';

	return apply_filters( 'clean_business_get_content', $content );
}

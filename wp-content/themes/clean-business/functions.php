<?php
/**
 * Clean Business functions and definitions
 *
 * @package Clean Business
 */

if ( ! function_exists( 'clean_business_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function clean_business_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'clean_business_content_width', '668' );
	}
endif;
add_action( 'after_setup_theme', 'clean_business_content_width', 0 );

if ( ! function_exists( 'clean_business_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function clean_business_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Clean Business, use a find and replace
	 * to change 'clean-business' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'clean-business', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style();

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 400, 300, true );

	// Used for Featured Slider Ratio 16:9
    add_image_size( 'clean-business-slider', 1920, 1280, true);
    add_image_size( 'clean-business-featured', 728, 410, true ); // used in Featured Imge Ratio 16:9
 	add_image_size( 'clean-business-square', 250, 250, true ); // used in Featured image 1:1
    add_image_size( 'clean-business-featured-content', 350, 197, true ); // used in Featured Content Options Ratio 16:9
	add_image_size( 'clean-business-small', 90, 68, true ); // used in Widgets


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'clean-business' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Dark Color Scheme
	$color_scheme = apply_filters( 'clean_business_get_option', 'color_scheme' );

	if ( 'dark' == $color_scheme ) {
		$background_color = clean_business_get_default_theme_options( 'background_color' );
	}
	else {
		$default_dark     = clean_business_default_dark_color_options();
		$background_color = $default_dark['background_color'];
	}

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'clean_business_custom_background_args', array(
		'default-color' => $background_color,
	) ) );

	/**
	 * Setup Custom Logo Support for theme
	 * Supported from WordPress version 4.5 onwards
	 * More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
	 */
	add_theme_support( 'custom-logo' );
}
endif; // clean_business_setup
add_action( 'after_setup_theme', 'clean_business_setup' );

/**
 * Enqueue scripts and styles.
 */
function clean_business_scripts() {
	$fonts_url = clean_business_fonts_url();

	if ( '' != $fonts_url ) {
		//Enqueue Google fonts
		wp_register_style( 'clean-business-fonts', $fonts_url, array(), '1.0.0' );

		$styles_deps[] = 'clean-business-fonts';
	}

	wp_enqueue_style( 'bootstrap', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/bootstrap/bootstrap.min.css', array(), true );

	wp_enqueue_style( 'clean-business-style', get_stylesheet_uri() , $styles_deps );

	// Dark Color Scheme
	$color_scheme = apply_filters( 'clean_business_get_option', 'color_scheme' );
	if ( 'dark' == $color_scheme ) {
		wp_enqueue_style( 'clean-business-dark', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/dark.css', array(), null );
	}

	wp_enqueue_style( 'font-awesome', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'fonts/font-awesome.min.css' );

	wp_enqueue_style( 'clean-business-ie9', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/ie9.css', array( 'clean-business-style' ) );
	wp_style_add_data( 'clean-business-ie9', 'conditional', 'lte IE 9' );

	wp_enqueue_script( 'clean-business-scripts', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/scripts.js', array( 'jquery', 'imagesloaded' ),'', true );

	wp_enqueue_script( 'clean-business-main', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/main.min.js', array( 'jquery' ),'', true );

	wp_enqueue_script( 'clean-business-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'clean-business-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/navigation.min.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'clean_business_scripts' );

/**
 * Register Google fonts.
 *
 */
function clean_business_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Merriweather, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$merriweather = _x( 'on', 'Merriweather: on or off', 'clean-business' );

	/* Translators: If there are characters in your language that are not
	* supported by Lato, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$lato = _x( 'on', 'Lato font: on or off', 'clean-business' );

	if ( 'off' !== $merriweather || 'off' !== $lato ) {
		$font_families = array();

		if ( 'off' !== $merriweather ) {
		$font_families[] = 'Merriweather';
		}

		if ( 'off' !== $lato ) {
		$font_families[] = 'Lato';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

if ( ! function_exists( 'clean_business_get_theme_layout' ) ) :
	/**
	 * Returns Theme Layout prioritizing the meta box layouts
	 *
	 * @uses  get_theme_mod
	 *
	 * @action wp_head
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_get_theme_layout() {
		$id = '';

		global $post, $wp_query;

	    // Front page displays in Reading Settings
		$page_on_front  = get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		// Blog Page or Front Page setting in Reading Settings
		if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
	        $id = $page_id;
	    }
	    else if ( is_singular() ) {
	 		if ( is_attachment() ) {
				$id = $post->post_parent;
			}
			else {
				$id = $post->ID;
			}
		}

		//Get appropriate metabox value of layout
		if ( '' != $id ) {
			$layout = get_post_meta( $id, 'clean-business-layout-option', true );
		}
		else {
			$layout = 'default';
		}

		//check empty and load default
		if ( empty( $layout ) || 'default' == $layout ) {
			$layout = apply_filters( 'clean_business_get_option', 'theme_layout' );
		}

		return $layout;
	}
endif; //clean_business_get_theme_layout

/**
 * Migrate Custom CSS to WordPress core Custom CSS
 *
 * Runs if version number saved in theme_mod "custom_css_version" doesn't match current theme version.
 */
function clean_business_custom_css_migrate(){
	$ver = get_theme_mod( 'custom_css_version', false );

	// Return if update has already been run
	if ( version_compare( $ver, '4.7' ) >= 0 ) {
		return;
	}

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
	    // Migrate any existing theme CSS to the core option added in WordPress 4.7.

	    /**
		 * Get Theme Options Values
		 */
	    $custom_css = apply_filters( 'clean_business_get_option', 'custom_css' );

	    if ( '' != $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );

	        if ( ! is_wp_error( $return ) ) {
	            // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
	            remove_theme_mod( 'custom_css' );

	            // Update to match custom_css_version so that script is not executed continously
				set_theme_mod( 'custom_css_version', '4.7' );
	        }
	    }
	}
}
add_action( 'after_setup_theme', 'clean_business_custom_css_migrate' );

/**
 * Load Default Options and other functions that return static data
 */
require trailingslashit( get_template_directory() ) . 'inc/default-options.php';

/**
 * Implement the Custom Header feature.
 */
require trailingslashit( get_template_directory() ) . 'inc/custom-header.php';

/**
 * Woocommerce basic integration
 */
require trailingslashit( get_template_directory() ) . 'inc/widgets/widgets.php';

/**
 * Custom template tags for this theme.
 */
require trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require trailingslashit( get_template_directory() ) . 'inc/core.php';

/**
 * Main structure file for theme.
 */
require trailingslashit( get_template_directory() ) . 'inc/structure.php';

/**
 * Customizer additions.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

/**
 * Slider
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-slider.php';

/**
 * Featured Content
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-content.php';

/**
 * Breadcrumb
 */
require trailingslashit( get_template_directory() ) . 'inc/breadcrumb.php';

/**
 * Social Icons
 */
require trailingslashit( get_template_directory() ) . 'inc/social-icons.php';

/**
 * Add Metabox
 */
require trailingslashit( get_template_directory() ) . 'inc/metabox.php';

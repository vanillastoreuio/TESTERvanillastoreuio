<?php
/**
 * The template for Managing Theme Structure
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

if ( ! function_exists( 'clean_business_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'clean_business_doctype', 'clean_business_doctype', 10 );

if ( ! function_exists( 'clean_business_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
endif;
add_action( 'clean_business_before_wp_head', 'clean_business_head', 10 );

if ( ! function_exists( 'clean_business_preloader' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_preloader() {
		?>
		<div class="preloader">
		    <div class="spinner">
		        <div class="pre-bounce1"></div>

		        <div class="pre-bounce2"></div>
		    </div><!-- .spinner -->
		</div><!-- .preloader -->
		<?php
	}
endif;
add_action( 'clean_business_before', 'clean_business_preloader', 10 );

if ( ! function_exists( 'clean_business_doctype_start' ) ) :
	/**
	 * Start div id #page with Skip to content
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_page_start() {
		?>
		<div id="page" class="hfeed site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'clean-business' ); ?></a>
		<?php
	}
endif;
add_action( 'clean_business_header', 'clean_business_page_start', 10 );

if ( ! function_exists( 'clean_business_header_start' ) ) :
	/**
	 * Start Header id #masthead with class .header-wrap, .container and .row
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_header_start() {
		?>
		<header id="masthead" class="site-header" role="banner">
    		<div class="header-wrap">
    			<div class="container">
                	<div class="row">
		<?php
	}
endif;
add_action( 'clean_business_header', 'clean_business_header_start', 20 );

if ( ! function_exists( 'clean_business_site_branding' ) ) :
	/**
	 * display logo and site-header
	 *
	 * @uses get_transient, clean_business_get_option, get_header_textcolor, get_bloginfo, set_transient, display_header_text
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @action
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_site_branding() {
		$site_logo = '';
		//Checking Logo
		if ( has_custom_logo() ) {
			$site_logo = '<div id="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';
		}

		$tagline_class     = '';

		$hide_tagline = apply_filters( 'clean_business_get_option', 'hide_tagline' );

		if ( $hide_tagline ) {
			$tagline_class = ' screen-reader-text';
		}

		$header_text = '<div id="site-header">';

		//Set screen-reader-text class if site-header is disabled
		if ( !display_header_text() ) {
			$header_text = '<div id="site-header" class="screen-reader-text">';
		}

		//Add Site Title
		$header_text .= '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';

		//Add Tagline
		$header_text .= '<h2 class="site-description' . $tagline_class . '">' . get_bloginfo( 'description' ) . '</h2>';

		//End Site Header
		$header_text .= '</div><!-- #site-header -->';

		$text_color = get_header_textcolor();

		$site_branding	= '<div id="site-branding">' . $header_text;

		if ( has_custom_logo() ) {
			$move_title_tagline = apply_filters( 'clean_business_get_option', 'move_title_tagline' );

			if( $move_title_tagline ) {
				$site_branding  = '<div id="site-branding" class="logo-right">' . $header_text . $site_logo;
			}
			else {
				$site_branding  = '<div id="site-branding" class="logo-left">' . $site_logo . $header_text;
			}
		}

		$site_branding 	.= '</div><!-- #site-branding-->';

		echo '<div class="col-md-4 col-sm-8 col-xs-12">' . $site_branding . '</div>';
	}
endif; // clean_business_site_branding
add_action( 'clean_business_header', 'clean_business_site_branding', 30 );

if ( ! function_exists( 'clean_business_primary_menu' ) ) :
	/**
	 * display logo and site-header
	 *
	 * @uses get_transient, clean_business_get_option, get_header_textcolor, get_bloginfo, set_transient, display_header_text
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @action
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_primary_menu() {
		?>
			<div class="col-md-8 col-sm-4 col-xs-12">
				<div class="btn-menu"></div>

				<nav id="mainnav" class="nav-primary" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
			</div><!-- .col-md-8 -->
		<?php
	}
endif; // clean_business_primary_menu
add_action( 'clean_business_header', 'clean_business_primary_menu', 40 );

if ( ! function_exists( 'clean_business_header_end' ) ) :
	/**
	 * End Header id #masthead and class .wrapper
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_header_end() {
		?>
					</div><!-- .header-wrap -->
				</div><!-- .container -->
			</div><!-- .row -->
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'clean_business_header', 'clean_business_header_end', 100 );

if ( ! function_exists( 'clean_business_content_start' ) ) :
	/**
	 * Start div id #content and class .container and .row
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_content_start() {
		?>
		<div id="content" class="page-wrap">
			<div class="container content-wrapper">
				<div class="row">
	<?php
	}
endif;
add_action('clean_business_content', 'clean_business_content_start', 10 );

if ( ! function_exists( 'clean_business_content_end' ) ) :
	/**
	 * End div id #content and class .wrapper
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_content_end() {
		?>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- #content -->
		<?php
	}

endif;
add_action( 'clean_business_after_content', 'clean_business_content_end', 10 );

if ( ! function_exists( 'clean_business_footer_sidebar' ) ) :
/**
 * Footer Sidebar
 *
 * @since Clean Business 0.1
 */
function clean_business_footer_sidebar() {
	get_sidebar( 'footer' );
}
endif;
add_action( 'clean_business_footer', 'clean_business_footer_sidebar', 10 );

if ( ! function_exists( 'clean_business_footer_content_start' ) ) :
/**
 * Start footer id #colophon
 *
 * @since Clean Business 0.1
 */
function clean_business_footer_content_start() {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
}
endif;
add_action('clean_business_footer', 'clean_business_footer_content_start', 30 );

if ( ! function_exists( 'clean_business_footer_content_end' ) ) :
/**
 * End footer id #colophon
 *
 * @since Clean Business 0.1
 */
function clean_business_footer_content_end() {
	?>
	</footer><!-- #colophon -->
	<?php
}
endif;
add_action( 'clean_business_footer', 'clean_business_footer_content_end', 110 );

if ( ! function_exists( 'clean_business_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Clean Business 0.1
	 *
	 */
	function clean_business_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'clean_business_footer', 'clean_business_page_end', 200 );

<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Clean Business
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses clean_business_header_style()
 * @uses clean_business_admin_header_style()
 * @uses clean_business_admin_header_image()
 */
function clean_business_custom_header_setup() {
	$color_scheme = apply_filters( 'clean_business_get_option', 'color_scheme' );

	if ( 'light' == $color_scheme ) {
		$defaults = clean_business_get_default_theme_options();
	}
	else if ( 'dark' == $color_scheme ) {
		$defaults = clean_business_default_dark_color_options();

	}

	$default_header_color = $defaults['header_textcolor'];

	add_theme_support( 'custom-header', apply_filters( 'clean_business_custom_header_args', array(
		'default-image'          => trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/header.jpg',
		'default-text-color'     => $default_header_color,
		'width'                  => 1920,
		'height'                 => 600,
		'flex-height'            => true,
		'admin-head-callback'    => 'clean_business_admin_header_style',
		'admin-preview-callback' => 'clean_business_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'clean_business_custom_header_setup' );

if ( ! function_exists( 'clean_business_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see clean_business_custom_header_setup().
 */
function clean_business_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // clean_business_admin_header_style

if ( ! function_exists( 'clean_business_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see clean_business_custom_header_setup().
 */
function clean_business_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // clean_business_admin_header_image

if ( ! function_exists( 'clean_business_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_featured_image(), and that function will be used instead.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_featured_image() {
		$header_image = get_header_image();

		//Support Random Header Image
		if ( is_random_header_image() ) {
			delete_transient( 'clean_business_featured_image' );
		}

		if ( !$output = get_transient( 'clean_business_featured_image' ) ) {

			echo '<!-- refreshing cache -->';

			if ( '' != $header_image ) {

				// Header Image Link and Target
				$url = apply_filters( 'clean_business_get_option', 'featured_header_image_url' );

				$link   = '';
				$target = '_self';

				if ( $url ) {
					//support for qtranslate custom link
					if ( function_exists( 'qtrans_convertURL' ) ) {
						$link = qtrans_convertURL( $url );
					}
					else {
						$link = $url;
					}

					//Checking Link Target
					$base = apply_filters( 'clean_business_get_option', 'featured_header_image_base' );

					if ( $base )  {
						$target = '_blank';
					}
				}

				// Header Image Title/Alt
				$title = apply_filters( 'clean_business_get_option', 'featured_header_image_alt' );

				// Header Image
				$feat_image = '<img class="wp-post-image" alt="'. esc_attr( $title ).'" src="'.esc_url( $header_image ).'" />';

				$output = '<div id="header-featured-image">
					<div class="wrapper">';
					// Header Image Link
					if ( '' != $link ) {
						$output .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="'. esc_attr( $target ) .'">' . $feat_image . '</a>';
					}
					else {
						// if empty featured_header_image on theme options, display default
						$output .= $feat_image;
					}
				$output .= '</div><!-- .wrapper -->
				</div><!-- #header-featured-image -->';
			}

			set_transient( 'clean_business_featured_image', $output, 86940 );
		}

		echo $output;

	} // clean_business_featured_image
endif;


if ( ! function_exists( 'clean_business_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		if ( is_home() && $page_for_posts == $page_id ) {
			$header_page_id = $page_id;
		}
		else {
			$header_page_id = $post->ID;
		}

		if( has_post_thumbnail( $header_page_id ) ) {
		   	$featured_header_image_url	= apply_filters( 'featured_header_image_url', 'featured_header_image_base' );
			$featured_header_image_base	= apply_filters( 'clean_business_get_option', 'featured_header_image_base' );

			if ( '' != $featured_header_image_url ) {
				//support for qtranslate custom link
				if ( function_exists( 'qtrans_convertURL' ) ) {
					$link = qtrans_convertURL( $featured_header_image_url );
				}
				else {
					$link = esc_url( $featured_header_image_url );
				}
				//Checking Link Target
				if ( '1' == $featured_header_image_base ) {
					$target = '_blank';
				}
				else {
					$target = '_self';
				}
			}
			else {
				$link = '';
				$target = '';
			}

			$title	= apply_filters( 'clean_business_get_option', 'featured_header_image_alt' );

			$featured_image_size	= apply_filters( 'clean_business_get_option', 'featured_image_size' );

			$feat_image = get_the_post_thumbnail( $post->ID, $featured_image_size, array('id' => 'main-feat-img'));

			$output = '<div id="header-featured-image" class =' . $featured_image_size . '>';
				// Header Image Link
				if ( '' != $featured_header_image_url ) :
					$output .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="' . $target . '">' . $feat_image . '</a>';
				else:
					// if empty featured_header_image on theme options, display default
					$output .= $feat_image;
				endif;
			$output .= '</div><!-- #header-featured-image -->';

			echo $output;
		}
		else {
			clean_business_featured_image();
		}
	} // clean_business_featured_page_post_image
endif;


if ( ! function_exists( 'clean_business_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_featured_overall_image() {
		global $post, $wp_query;
		$enable_header_image = apply_filters( 'clean_business_get_option', 'enable_featured_header_image' );

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'clean-business-header-image', true );

			if ( 'disabled' == $individual_featured_image  || ( 'default' == $individual_featured_image  && 'disabled' == $enable_header_image  ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( 'enable' == $individual_featured_image  && 'disabled' == $enable_header_image  ) {
				clean_business_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				clean_business_featured_image();
			}
		}
		// Check Excluding Homepage
		if ( 'exclude-homepage' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				clean_business_featured_image();
			}
		}
		elseif ( 'exclude-home-page-post' == $enable_header_image  ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				clean_business_featured_page_post_image();
			}
			else {
				clean_business_featured_image();
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' == $enable_header_image  ) {
			clean_business_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				clean_business_featured_page_post_image();
			}
			else {
				clean_business_featured_image();
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' == $enable_header_image  ) {
			if ( is_page() || is_single() ) {
				clean_business_featured_page_post_image();
			}
		}
		else {
			echo '<!-- Disable Header Image -->';
		}
	} // clean_business_featured_overall_image
endif;
add_action( 'clean_business_after_header', 'clean_business_featured_overall_image', 10 );

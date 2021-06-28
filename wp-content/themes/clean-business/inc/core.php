<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Clean Business
 */

function clean_business_get_option( $value ) {
	return get_theme_mod( $value, clean_business_get_default_theme_options( $value ) );
}
add_filter( 'clean_business_get_option', 'clean_business_get_option' );


/**
 * Flush out all transients
 *
 * @uses delete_transient
 *
 * @action customize_save, clean_business_customize_preview (see clean_business_customizer function: clean_business_customize_preview)
 *
 * @since Clean Business 0.1
 */
function clean_business_flush_transients(){
	delete_transient( 'clean_business_featured_content' );

	delete_transient( 'clean_business_featured_slider' );

	delete_transient( 'clean_business_custom_css' );

	delete_transient( 'clean_business_footer_content' );

	delete_transient( 'clean_business_featured_image' );

	delete_transient( 'clean_business_social_icons' );

	delete_transient( 'clean_business_scrollup' );

	delete_transient( 'all_the_cool_cats' );
}
add_action( 'customize_save', 'clean_business_flush_transients' );


/**
 * Flush out post related transients
 *
 * @uses delete_transient
 *
 * @action save_post
 *
 * @since Clean Business 0.1
 */
function clean_business_flush_post_transients(){
	delete_transient( 'clean_business_featured_content' );

	delete_transient( 'clean_business_featured_slider' );

	delete_transient( 'clean_business_featured_image' );

	delete_transient( 'all_the_cool_cats' );
}
add_action( 'save_post', 'clean_business_flush_post_transients' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function clean_business_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$layout = clean_business_get_theme_layout();

	switch ( $layout ) {
		case 'left-sidebar':
			$classes[] = 'two-columns content-right';
		break;

		case 'right-sidebar':
			$classes[] = 'two-columns content-left';
		break;

		case 'no-sidebar':
			$classes[] = 'no-sidebar content-width';
		break;
	}

	$classes[] = apply_filters( 'clean_business_get_option', 'content_layout' );

	global $post, $wp_query;
	$enable_slider 	= apply_filters( 'clean_business_get_option', 'featured_slider_option' );

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	$slider_disabled = true;

	//Check if slider is inactive
	 if( 'entire-site' == $enable_slider || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider ) ) {
	 	$slider_disabled = false;
	 }

	//Check if header image is enabled
	$header_image_disabled = false;

	$enable_header_image = apply_filters( 'clean_business_get_option', 'enable_featured_header_image' );

	// Check Enable/Disable header image in Page/Post Meta box
	if ( is_page() || is_single() ) {
		//Individual Page/Post Image Setting
		$individual_featured_image = get_post_meta( $post->ID, 'clean-business-header-image', true );

     	if ( 'disabled' == $individual_featured_image || ( ( '' == $individual_featured_image || 'default' == $individual_featured_image ) && 'disabled' == $enable_header_image ) ) {
			$header_image_disabled = true;
		}
	}

	if( 'disabled' == $enable_header_image ) {
		$header_image_disabled = true;
	}
	// Check Homepage
	elseif ( 'homepage' == $enable_header_image && !( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) {
		$header_image_disabled = true;
	}
	// Check Excluding Homepage
	if ( 'exclude-homepage' == $enable_header_image && ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) {
		$header_image_disabled = true;
	}
	elseif ( 'exclude-home-page-post' == $enable_header_image && ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) {
		$header_image_disabled = true;
	}
	// Check Page/Post
	elseif ( 'pages-posts' ==  $enable_header_image && ( !( is_page() || is_single() ) ) ) {
		$header_image_disabled = true;
	}

	if ( $slider_disabled && $header_image_disabled ) {
		//Add class if both slider and header image is  disabled
		$classes[] = 'header-bg';
	}

	$classes[] = apply_filters( 'clean_business_get_option', 'color_scheme' );

	return $classes;
}
add_filter( 'body_class', 'clean_business_body_classes' );

if ( ! function_exists( 'clean_business_post_classes' ) ) :
	/**
	 * Adds clean business post classes to the array of post classes.
	 * used for supporting different content layouts
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_post_classes( $classes ) {
		$content_layout = apply_filters( 'clean_business_get_option', 'content_layout' );

		if ( is_archive() || is_home() ) {
			$classes[] = $content_layout;
		}

		return $classes;
	}
endif; //clean_business_post_classes
add_filter( 'post_class', 'clean_business_post_classes' );

if ( ! function_exists( 'clean_business_get_comment_section' ) ) :
	/**
	 * Comment Section
	 *
	 * @get comment setting from theme options and display comments sections accordingly
	 * @display comments_template
	 * @action clean_business_comment_section
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_get_comment_section() {
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template();
		}
	}
endif;
add_action( 'clean_business_comment_section', 'clean_business_get_comment_section', 10 );

if ( ! function_exists( 'clean_business_custom_css' ) ) :
	/**
	 * Enqueue Custon CSS
	 *
	 * @uses  set_transient, wp_head, wp_enqueue_style
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_custom_css() {
		//clean_business_flush_transients();

		if ( ( !$custom_css = get_transient( 'clean_business_custom_css' ) ) ) {
			$defaults      = clean_business_get_default_theme_options();
			$custom_css    ='';

			$text_color = get_header_textcolor();

			if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $text_color ) {
				$custom_css	.=  ".site-title a, .site-description { color: #".  esc_attr( $text_color ) ."; }" . "\n";
			}

			// Featured Content Background Image Options
			$options['featured_content_bg_image'] = apply_filters( 'clean_business_get_option', 'featured_content_bg_image' );

			if( $defaults['featured_content_bg_image'] != $options['featured_content_bg_image'] ) {
				$custom_css .= "#featured-content { background-image: url(\"". esc_url( $options['featured_content_bg_image'] ) ."\"); }" . "\n";
			}

			//Custom CSS Option
			$options['custom_css']	= apply_filters( 'clean_business_get_option', 'custom_css' );

			if( !empty( $options['custom_css'] ) ) {
				$custom_css	.= $options['custom_css'] . "\n";
			}

			if ( '' != $custom_css ){
				echo '<!-- refreshing cache -->' . "\n";

				$custom_css = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n" . '<style type="text/css" media="screen" rel="CT Custom CSS">' . "\n" . $custom_css;

				$custom_css .= '</style>' . "\n";

			}

			set_transient( 'clean_business_custom_css', htmlspecialchars_decode( $custom_css ), 86940 );
		}

		echo $custom_css;
	}
endif; //clean_business_custom_css
add_action( 'wp_head', 'clean_business_custom_css', 101  );

if ( ! function_exists( 'clean_business_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_excerpt_length( $length ) {
		$excerpt_length = apply_filters( 'clean_business_get_option', 'excerpt_length' );
		return $excerpt_length;
	}
endif; //clean_business_excerpt_length
add_filter( 'excerpt_length', 'clean_business_excerpt_length' );

if ( ! function_exists( 'clean_business_continue_reading' ) ) :
	/**
	 * Returns a "Custom Continue Reading" link for excerpts
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_continue_reading() {
		$excerpt_more_text = apply_filters( 'clean_business_get_option', 'excerpt_more_text' );

		return ' <span class="readmore"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $excerpt_more_text . '</a></span>';
	}
endif; //clean_business_continue_reading
add_filter( 'excerpt_more', 'clean_business_continue_reading' );

if ( ! function_exists( 'clean_business_more_link' ) ) :
	/**
	 * Replacing Continue Reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_more_link( $more_link, $more_link_text ) {
	 	$more_tag_text = apply_filters( 'clean_business_get_option', 'excerpt_more_text' );

		return str_replace( $more_link_text, $more_tag_text, $more_link );
	}
endif; //clean_business_more_link
add_filter( 'the_content_more_link', 'clean_business_more_link', 10, 2 );

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action clean_business_footer
 *
 * @since Clean Business 0.1
 */
function clean_business_footer_content() {
	//clean_business_flush_transients();
	if ( ( !$output = get_transient( 'clean_business_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';

		$content = clean_business_get_content();

		$output =  '
    	<div id="site-generator" class="site-info container two">
    		<div class="row">
    			<div id="footer-left-content" class="copyright col-md-6">' . $content['left'] . '</div>

    			<div id="footer-right-content" class="powered col-md-6">' . $content['right'] . '</div>
			</div><!-- .row -->
		</div><!-- #site-generator -->';

    	set_transient( 'clean_business_footer_content', $output, 86940 );
    }

    echo $output;
}
add_action( 'clean_business_footer', 'clean_business_footer_content', 100 );

/**
 * Alter the query for the main loop in homepage
 *
 * @action pre_get_posts
 *
 * @since Clean Business 0.1
 */
function clean_business_alter_home( $query ){
	if( $query->is_main_query() && $query->is_home() ) {
	$cats = apply_filters( 'clean_business_get_option', 'front_page_category' );
		if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] =  $cats;
		}
	}
}
add_action( 'pre_get_posts','clean_business_alter_home' );

if ( ! function_exists( 'clean_business_archive_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_archive_content_image(), and that function will be used instead.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_archive_content_image() {
		$content_layout = apply_filters( 'clean_business_get_option', 'content_layout' );
		$theme_layout   = clean_business_get_theme_layout();

		if ( has_post_thumbnail() && 'full-content' != $content_layout ) { ?>
			<div class="entry-thumb">
	            <a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	            <?php
	            	if ( 'excerpt-image-left' == $content_layout  || 'excerpt-image-right' == $content_layout ) {
	                     the_post_thumbnail( 'clean-business-square' );
	                }
	                else {
	                	the_post_thumbnail( 'clean-business-featured' );
	                }
				?>
				</a>
	        </div><!-- .entry-thumb -->
	   	<?php
		}
	}
endif; //clean_business_archive_content_image
add_action( 'clean_business_before_entry_container', 'clean_business_archive_content_image', 10 );


if ( ! function_exists( 'clean_business_single_content_image' ) ) :
	/**
	 * Template for Featured Image in Single Post
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_single_content_image(), and that function will be used instead.
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_single_content_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if( $post) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;
				$individual_featured_image = get_post_meta( $parent,'clean-business-featured-image', true );
			} else {
				$individual_featured_image = get_post_meta( $page_id,'clean-business-featured-image', true );
			}
		}

		if( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
			$individual_featured_image = 'default';
		}

		// Getting data from Theme Options
	   	$featured_image = apply_filters( 'clean_business_get_option', 'single_post_image_layout' );

		if ( ( 'disabled' == $individual_featured_image  || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && 'disabled' == $featured_image ) ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $individual_featured_image ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $individual_featured_image;
			}

			?>
			<div class="entry-thumb <?php echo $class; ?>">
                <?php the_post_thumbnail( $individual_featured_image ); ?>
	        </div><!-- .entry-thumb -->
	   	<?php
		}
	}
endif; //clean_business_single_content_image
add_action( 'clean_business_before_post_container', 'clean_business_single_content_image', 10 );
add_action( 'clean_business_before_page_container', 'clean_business_single_content_image', 10 );

if ( ! function_exists( 'clean_business_promotion_headline' ) ) :
	/**
	 * Template for Promotion Headline
	 *
	 * To override this in a child theme
	 * simply create your own clean_business_promotion_headline(), and that function will be used instead.
	 *
	 * @uses clean_business_before_main action to add it in the header
	 * @since Clean Business 0.1
	 */
	function clean_business_promotion_headline() {
		global $post, $wp_query;
	   	$enable_promotion = apply_filters( 'clean_business_get_option', 'promotion_headline_option' );


		// Front page displays in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		if ( 'entire-site' == $enable_promotion || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' ==  $enable_promotion  ) ) {
			echo '
				<div id="promotion-message">
					<div class="container">';

		    	$clean_business_promotion_headline    = apply_filters( 'clean_business_get_option', 'promotion_headline' );
					$clean_business_promotion_subheadline = apply_filters( 'clean_business_get_option', 'promotion_subheadline' );

					echo '
					<div class="section left">';

					if ( "" != $clean_business_promotion_headline ) {
						echo '<h2 class="promotion-title entry-title">' . $clean_business_promotion_headline . '</h2>';
					}

					if ( "" != $clean_business_promotion_subheadline ) {
						echo '<p>' . $clean_business_promotion_subheadline . '</p>';
					}

					echo '
					</div><!-- .section.left -->';

					$clean_business_promotion_headline_button = apply_filters( 'clean_business_get_option', 'promotion_headline_button' );
					$clean_business_promotion_headline_target = apply_filters( 'clean_business_get_option', 'promotion_headline_target' );
		    		$clean_business_promotion_headline_url = apply_filters( 'clean_business_get_option', 'promotion_headline_url' );
		    		//support qTranslate plugin
					if ( function_exists( 'qtrans_convertURL' ) ) {
						$clean_business_promotion_headline_url = qtrans_convertURL( $clean_business_promotion_headline_url );
					}

					if ( "" != $clean_business_promotion_headline_url ) {
							if ( "1" == $clean_business_promotion_headline_target ) {
								$clean_business_headlinetarget = '_blank';
							}
							else {
								$clean_business_headlinetarget = '_self';
							}

						echo '
						<div class="section right">
							<a class="promotion-button roll-button more-button" href="' . esc_url( $clean_business_promotion_headline_url ) . '" target="' . $clean_business_headlinetarget . '">' . esc_attr( $clean_business_promotion_headline_button ) . '
							</a>
						</div><!-- .section.right -->';
					}
				echo '
					</div><!-- .container -->
				</div><!-- #promotion-message -->';
		}
	}
endif; // clean_business_promotion_featured_content
add_action( 'clean_business_before_content', 'clean_business_promotion_headline', 30 );

if ( ! function_exists( 'clean_business_scrollup' ) ) {
	/**
	 * This function loads Scroll Up Navigation
	 *
	 * @action clean_business_footer action
	 * @uses set_transient and delete_transient
	 */
	function clean_business_scrollup() {
		//clean_business_flush_transients();
		if ( !$output = get_transient( 'clean_business_scrollup' ) ) {
			// get the data value from theme options
			$disable_scrollup = apply_filters( 'clean_business_get_option', 'disable_scrollup' );
			echo '<!-- refreshing cache -->';

			//site stats, analytics header code
			if ( !$disable_scrollup ) {
				$output =  '<a class="scrollup"><i class="fa fa-angle-up"></i></a>' ;
			}

			set_transient( 'clean_business_scrollup', $output, 86940 );
		}
		echo $output;
	}
}
add_action( 'clean_business_footer', 'clean_business_scrollup', 20 );

/**
 * Return registered image sizes.
 *
 * Return a two-dimensional array of just the additionally registered image sizes, with width, height and crop sub-keys.
 *
 * @since 1.0
 *
 * @global array $_wp_additional_image_sizes Additionally registered image sizes.
 *
 * @return array Two-dimensional, with width, height and crop sub-keys.
 */
function clean_business_get_additional_image_sizes() {
	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes ) {
		return $_wp_additional_image_sizes;
	}

	return array();
}

/**
 * Display Multiple Select type for and array of categories
 *
 * @param  [string] $name  [field name]
 * @param  [string] $id    [field_id]
 * @param  [array] $selected    [selected values]
 * @param  string $label [label of the field]
 */
function clean_business_dropdown_categories( $name, $id, $selected, $label = '' ) {
	$dropdown = wp_dropdown_categories(
		array(
			'name'             => $name,
			'echo'             => 0,
			'hide_empty'       => false,
			'show_option_none' => false,
			'hierarchical'       => 1,
		)
	);

	if ( '' != $label ) {
		echo '<label for="' . $id . '">
			'. $label .'
			</label>';
	}

	$dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:120px; width: 100%" ', $dropdown );

	foreach( $selected as $selected ) {
		$dropdown = str_replace( 'value="'. $selected .'"', 'value="'. $selected .'" selected="selected"', $dropdown );
	}

	echo $dropdown;

	echo '<span class="description">'. esc_html__( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'clean-business' ) . '</span>';
}

if ( ! function_exists( 'clean_business_get_highlight_meta' ) ) :
	/**
	 * Returns HTML with meta information for the categories, tags, date and author.
	 *
	 * @param [boolean] $hide_category Adds screen-reader-text class to category meta if true
	 * @param [boolean] $hide_tags Adds screen-reader-text class to tag meta if true
	 * @param [boolean] $hide_posted_by Adds screen-reader-text class to date meta if true
	 * @param [boolean] $hide_author Adds screen-reader-text class to author meta if true
	 *
	 * @since Clean Business 0.1
	 */
	function clean_business_get_highlight_meta( $hide_category = false, $hide_tags = false, $hide_posted_by = false, $hide_author = false ) {
		$output = '<p class="entry-meta">';

		if ( 'post' == get_post_type() ) {

			$class = $hide_category ? 'screen-reader-text' : '';

			$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'clean-business' ) );
			if ( $categories_list && clean_business_categorized_blog() ) {
				$output .= sprintf( '<span class="cat-links ' . $class . '">%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'clean-business' ) ),
					$categories_list
				);
			}

			$class = $hide_tags ? 'screen-reader-text' : '';

			$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'clean-business' ) );
			if ( $tags_list ) {
				$output .= sprintf( '<span class="tags-links ' . $class . '"><i class="fa fa-tags"></i>%1$s%2$s</span>',
					sprintf( _x( '<span class="screen-reader-text">Tags</span>', 'Used before tag names.', 'clean-business' ) ),
					$tags_list
				);
			}

			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			$class = $hide_posted_by ? 'screen-reader-text' : '';

			$output .= sprintf( '<span class="posted-on ' . $class . '">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
				sprintf( _x( '<span class="screen-reader-text">Posted on</span>', 'Used before publish date.', 'clean-business' ) ),
				esc_url( get_permalink() ),
				$time_string
			);

			if ( is_singular() || is_multi_author() ) {
				$class = $hide_author ? 'screen-reader-text' : '';

				$output .= sprintf( '<span class="byline ' . $class . '"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
					sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'clean-business' ) ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html( get_the_author() )
				);
			}
		}

		$output .= '</p><!-- .entry-meta -->';

		return $output;
	}
endif; //clean_business_get_highlight_meta

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @param [string/array] $src set true to return only image source
 * @return [string] image html
 *
 * @since Clean Business 0.1
 */

function clean_business_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="wp-post-image" src="'. $first_img .'">';
	}

	return false;
}

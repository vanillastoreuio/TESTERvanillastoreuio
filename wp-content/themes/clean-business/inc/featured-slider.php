<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

if( !function_exists( 'clean_business_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook clean_business_before_content.
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_slider() {
	global $wp_query;
	//clean_business_flush_transients();
	$enable_slider 	= apply_filters( 'clean_business_get_option', 'featured_slider_option' );
	$slider_select 	= apply_filters( 'clean_business_get_option', 'featured_slider_type' );

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	if ( 'entire-site' == $enable_slider  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_slider  ) ) {
		if( ( !$clean_business_featured_slider = get_transient( 'clean_business_featured_slider' ) ) ) {
			echo '<!-- refreshing cache -->';

			$image_loader	= apply_filters( 'clean_business_get_option', 'featured_slider_image_loader' );

			$transition_effect = apply_filters( 'clean_business_get_option', 'featured_slider_transition_effect' );

			$speed = apply_filters( 'clean_business_get_option', 'featured_slider_speed' );

			$transition_delay  = apply_filters( 'clean_business_get_option', 'featured_slider_transition_delay' );

			$clean_business_featured_slider = '
				<div id="slideshow" class="header-slider '. esc_attr( $slider_select ) .'" data-speed="'. esc_attr( $speed * 1000 ) .'" data-fx="'. esc_attr( $transition_effect ) .'">
					<div class="slides-container">';
						// Select Slider
						if ( 'demo-featured-slider' == $slider_select  ) {
							$clean_business_featured_slider .=  clean_business_demo_slider();
						}
						else if ( 'featured-post-slider' == $slider_select  || 'featured-page-slider' == $slider_select  || 'featured-category-slider' == $slider_select  ) {
							$clean_business_featured_slider .=  clean_business_post_page_category_slider();
						}

			$clean_business_featured_slider .= '
					</div><!-- .slides-container -->
				</div><!-- #slideshow -->';

			set_transient( 'clean_business_featured_slider', $clean_business_featured_slider, 86940 );
		}
		echo $clean_business_featured_slider;
	}
}
endif;
add_action( 'clean_business_before_content', 'clean_business_featured_slider', 10 );


if ( ! function_exists( 'clean_business_demo_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from customizer options
 *
 * @since Clean Business 0.1
 *
 */
function clean_business_demo_slider() {
	return '
		<div class="slide-item" style="background-image:url(\''. esc_url( get_template_directory_uri() ) .'/images/gallery/slider1-1920x1280.jpg\')">
			<div class="slide-inner">
	            <div class="contain animated fadeInRightBig text-slider">
	                <h2 class="entry-title">A Place for Business</h2>
	                <p class="subtitle">Build Business WordPress Site</p>
	            </div>
	            <a href="#" class="roll-button border button-slider">Click Here</a>
	        </div><!-- .slide-inner -->
	    </div><!-- .slide-item -->

	    <div class="slide-item" style="background-image:url(\''. esc_url( get_template_directory_uri() ) .'/images/gallery/slider2-1920x1280.jpg\')">
			<div class="slide-inner">
	            <div class="contain animated fadeInRightBig text-slider">
	                <h2 class="entry-title">Clean WordPress Theme</h2>
	                <p class="subtitle">Easy customiztion through Theme Customizer</p>
	            </div>
	            <a href="#" class="roll-button border button-slider">Click Here</a>
	        </div><!-- .slide-inner -->
	    </div><!-- .slide-item -->';
}
endif; // clean_business_demo_slider


if ( ! function_exists( 'clean_business_post_page_category_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @param $options: clean_business_theme_options from customizer
 *
 * @since Clean Business 0.1
 */
function clean_business_post_page_category_slider() {
	global $post;

	$quantity   = apply_filters( 'clean_business_get_option', 'featured_slider_number' );
	$no_of_post = 0; // for number of posts
	$post_list  = array();// list of valid post/page ids
	$type       = apply_filters( 'clean_business_get_option', 'featured_slider_type' );
	$more_text  = apply_filters( 'clean_business_get_option', 'excerpt_more_text' );
	$output     = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if( 'featured-page-slider' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			$post_id = apply_filters( 'clean_business_get_option', 'featured_slider_page_' . $i );

			if ( $post_id && '' != $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
	}

	$args['posts_per_page'] = $no_of_post;

	$loop = new WP_Query( $args );

	$i=0;
	while ( $loop->have_posts() ) {
		$loop->the_post();

		$i++;

		if ( $i == 1 ) {
			$classes = 'post post-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post post-'.$post->ID.' hentry slides displaynone';
		}

		//Default value if there is no post thumbnail or first image
		$image = esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1920x800.jpg';


		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( $post->ID, 'clean-business-slider');
		}
		else {
			//Get the first image in page, returns false if there is no image
			$first_image = clean_business_get_first_image( $post->ID, 'clean-business-fluid-slider', '', true );

			//Set value of image as first image if there is an image present in the page
			if ( '' != $first_image ) {
				$image = $first_image;
			}
		}

	    $output .= '
		<div class="slide-item postid-'. $post->ID .'" style="background-image:url(\''. esc_url( $image ) .'\')">
			<div class="slide-inner">
	            <div class="contain animated fadeInRightBig text-slider">
	                <h2 class="entry-title">' . the_title( '','', false ) . '</h2>
	                <p class="subtitle">' . get_the_excerpt() . '</p>
	            </div>
	            <a href="'. esc_url( get_permalink() ) .'" class="roll-button border button-slider">'. esc_html( $more_text ) .'</a>
	        </div><!-- .slide-inner -->
	    </div><!-- .slide-item -->';
	} //end while

	wp_reset_postdata();

	return $output;
}
endif; // clean_business_post_page_category_slider

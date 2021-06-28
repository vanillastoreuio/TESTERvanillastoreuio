<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

if( !function_exists( 'clean_business_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook clean_business_before_content.
*
* @since Clean Business 0.1
*/
function clean_business_featured_content_display() {
	//clean_business_flush_transients();
	global $wp_query;

	// get data value from options
	$enable_content = apply_filters( 'clean_business_get_option', 'featured_content_option' );
	$content_select = apply_filters( 'clean_business_get_option', 'featured_content_type' );

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( 'entire-site' == $enable_content  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable_content  ) ) {
		if ( ( !$output = get_transient( 'clean_business_featured_content' ) ) ) {
			$layouts     = apply_filters( 'clean_business_get_option', 'featured_content_layout' );
			$headline    = apply_filters( 'clean_business_get_option', 'featured_content_headline' );
			$subheadline = apply_filters( 'clean_business_get_option', 'featured_content_subheadline' );

			echo '<!-- refreshing cache -->';

			$classes = $layouts .' ' . $content_select ;

			if ( 'demo-featured-content' == $content_select ) {
				$headline    = esc_html__( 'Featured Content', 'clean-business' );
				$subheadline = esc_html__( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'clean-business' );
			}

			$featured_content_position = apply_filters( 'clean_business_get_option', 'featured_content_position' );

			if ( $featured_content_position ) {
				$classes .= ' border-top' ;
			}

			$output ='
				<section id="featured-content" class="' . $classes . '">
					<div class="container">
						<div class="row">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$output .='<div class="featured-heading-wrap">';
								if ( !empty( $headline ) ) {
									$output .='<h2 id="featured-heading" class="entry-title">' . wp_kses_post( $headline ) . '</h2>';
								}
								if ( !empty( $subheadline ) ) {
									$output .='<p>' . wp_kses_post( $subheadline ) . '</p>';
								}
							$output .='</div><!-- .featured-heading-wrap -->';
						}

						$output .='
						<div class="featured-content-wrap">';
							// Select content
							if ( 'demo-featured-content' == $content_select ) {
								$output .= clean_business_demo_content();
							}
							else if ( 'featured-post-content' == $content_select || 'featured-page-content' == $content_select || 'featured-category-content' == $content_select ) {
								$output .= clean_business_post_page_category_content();
							}

			$output .='
							</div><!-- .row -->
						</div><!-- .featured-content-wrap -->';

			$button_text = apply_filters( 'clean_business_get_option', 'featured_content_button_text' );

			if ( '' != $button_text ) {
				$button_link = apply_filters( 'clean_business_get_option', 'featured_content_button_link' );
				$button_target = apply_filters( 'clean_business_get_option', 'featured_content_button_target' );

				$target = '_self';

				if ( $button_target ) {
					$target = '_blank';
				}

				$output .= '<a class="roll-button more-button" target="'. esc_attr( $target ) .'" href="'. esc_url( $button_link ) .'">'. esc_html( $button_text ) .'</a>';

			}
			$output .='
					</div><!-- .container -->
				</section><!-- #featured-content -->';

			set_transient( 'clean_business_featured_content', $output, 86940 );
		}
		echo $output;
	}
}
endif;

if ( ! function_exists( 'clean_business_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action clean_business_content, clean_business_after_secondary
 *
 * @since Clean Business 0.1
 */
function clean_business_featured_content_display_position() {
	// Getting data from Theme Options
	$featured_content_position = apply_filters( 'clean_business_get_option', 'featured_content_position' );

	if ( $featured_content_position ) {
		add_action( 'clean_business_after_content', 'clean_business_featured_content_display', 20 );
	}
	else {
		add_action( 'clean_business_before_content', 'clean_business_featured_content_display', 40 );
	}
}
endif; // clean_business_featured_content_display_position
add_action( 'wp_head', 'clean_business_featured_content_display_position' );

if ( ! function_exists( 'clean_business_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Clean Business 0.1
 *
 */
function clean_business_demo_content() {
	$clean_business_demo_content = '
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Central Park" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured1-350x197.jpg" />
			</figure>

			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Central Park" href="#">Central Park</a>
					</h2>
				</header>
				<div class="entry-content">
					<p>Central Park is is the most visited urban park in the United States as well as one of the most filmed locations in the world. It was opened in 1857 and is expanded in 843 acres of city-owned land.</p>
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Home Office" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured2-350x197.jpg" />
			</figure>

			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Home Office" href="#">Home Office</a>
					</h2>
				</header>
				<div class="entry-content">
					<p>It might be work, but it doesn\'t have to feel like it. All you need is a comfortable desk, nice laptop, home office furniture that keeps things organized, and the right lighting for the job.</p>
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Vespa Scooter" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured3-350x197.jpg" />
			</figure>

			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Vespa Scooter" href="#">Vespa Scooter</a>
					</h2>
				</header>
				<div class="entry-content">
					<p>The Vespa Scooter has evolved from a single model motor scooter manufactured in the year 1946 by Piaggio & Co. S.p.A. of Pontedera, Italy-to a full line of scooters, today owned by Piaggio.</p>
				</div>
			</div><!-- .entry-container -->
		</article>';

	$layouts = apply_filters( 'clean_business_get_option', 'featured_content_layout' );

	if( 'layout-four' == $layouts || 'layout-two' == $layouts ) {
		$clean_business_demo_content .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Antique Clock" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured4-350x197.jpg" />
			</figure>

			<div class="entry-container">
				<header class="entry-header">
					<h2 class="entry-title">
						<a title="Antique Clock" href="#">Antique Clock</a>
					</h2>
				</header>
				<div class="entry-content">
					<p>Antique clocks increase in value with the rarity of the design, their condition, and appeal in the market place. Many different materials were used in antique clocks.</p>
				</div>
			</div><!-- .entry-container -->
		</article>';
	}

	return $clean_business_demo_content;
}
endif; // clean_business_demo_content

if ( ! function_exists( 'clean_business_post_page_category_content' ) ) :
/**
 * This function to display featured posts/page/category content
 *
 * @since Clean Business 0.1
 */
function clean_business_post_page_category_content() {
	global $post;

	$quantity     = apply_filters( 'clean_business_get_option', 'featured_content_number' );

	$no_of_post   = 0; // for number of posts

	$post_list    = array();// list of valid post/page ids

	$show_content = apply_filters( 'clean_business_get_option', 'featured_content_show' );

	$type         = apply_filters( 'clean_business_get_option', 'featured_content_type' );

	$output       = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1 // ignore sticky posts
	);

	//Get valid number of posts
	if( 'featured-page-content' == $type  ) {
		for( $i = 1; $i <= $quantity; $i++ ){
			if( 'featured-page-content' == $type ) {
				$post_id = apply_filters( 'clean_business_get_option', 'featured_content_page_' . $i );
			}

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

		$title_attribute = the_title_attribute( 'echo=0' );

		$excerpt = get_the_excerpt();

		$output .= '
			<article id="featured-post-'. $i .'" class="hentry postid-'. $post->ID .'">';
			if ( has_post_thumbnail() ) {
				$output .= '
				<figure class="featured-content-image">
					<a href="' . esc_url( get_permalink() ) . '" title="'. $title_attribute .'">
					'. get_the_post_thumbnail( $post->ID, 'clean-business-featured-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) ) .'
					</a>
				</figure>';
			}
			else {
				$image = '<img class="no-featured-image wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1920x800.jpg" >';

				//Get the first image in page, returns false if there is no image
				$first_image = clean_business_get_first_image( $post->ID, 'clean-business-featured-content', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

				//Set value of image as first image if there is an image present in the page
				if ( '' != $first_image ) {
					$image = $first_image;
				}

				$output .= '
				<figure class="featured-homepage-image">
					<a href="' . esc_url( get_permalink() ) . '" title="'. $title_attribute .'">
						'. $image .'
					</a>
				</figure>';
			}

			$output .= '
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
						</h2>
					</header>';

					if ( 'excerpt' == $show_content ) {
						$output .= '<div class="entry-excerpt"><p>' . $excerpt . '</p></div><!-- .entry-excerpt -->';
					}
					elseif ( 'full-content' == $show_content ) {
						$content = apply_filters( 'the_content', get_the_content() );
						$content = str_replace( ']]>', ']]&gt;', $content );
						$output .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
					}

				$output .= '
				</div><!-- .entry-container -->
			</article><!-- .featured-post-'. $i .' -->';
	} //end while

	wp_reset_postdata();

	return $output;
}
endif; // clean_business_post_page_category_content

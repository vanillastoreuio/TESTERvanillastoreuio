<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Clean Business
 */

if ( ! function_exists( 'clean_business_the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function clean_business_the_posts_navigation() {
	global $wp_query, $post;

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$pagination_type = apply_filters( 'clean_business_get_option', 'pagination_type' );

	/**
	 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
	 * if it's active then disable pagination
	 */
	if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return false;
	}

	?>

	<div class="main-pagination clear">
		<?php
			/**
			 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
			 */
			if ( 'numeric' == $pagination_type && function_exists( 'wp_pagenavi' ) ) {
				echo '<nav class="navigation pagination-pagenavi" role="navigation">';
					wp_pagenavi();
				echo '</nav><!-- .pagination-pagenavi -->';
            }
            elseif ( 'numeric' == $pagination_type && function_exists( 'the_posts_pagination' ) ) {
				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous', 'clean-business' ),
					'next_text'          => esc_html__( 'Next', 'clean-business' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'clean-business' ) . ' </span>',
				) );
			}
            else {
           	?>
            	<nav role="navigation" id="nav-below" class="navigation posts-navigation">
            		<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'clean-business' ); ?></h3>
	            	<div class="nav-links">
	            		<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'clean-business' ) ); ?></div>
		                <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'clean-business' ) ); ?></div>
		            </div><!-- .nav-links -->
				</nav><!-- #nav -->
			<?php
            }
        ?>
	</div><!-- .main-pagination -->
	<?php
}
endif;

if ( ! function_exists( 'clean_business_the_post_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function clean_business_the_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<div class="nav-previous"><i class="fa fa-long-arrow-left"></i> %title</div>',
			'next_text' => '<div class="nav-next">%title <i class="fa fa-long-arrow-right"></i></div>'
		)
	);
} //clean_business_the_post_navigation
endif;

if ( ! function_exists( 'clean_business_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function clean_business_posted_on() {
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

	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	printf( '<span class="posted-on">%1$s<a href="%2$s" rel="bookmark">%3$s</a></span>',
		sprintf( _x( '<span class="screen-reader-text">Posted on</span>', 'Used before publish date.', 'clean-business' ) ),
		esc_url( get_permalink() ),
		$time_string
	);

	if ( is_singular() || is_multi_author() ) {
		printf( '<span class="byline"><span class="author vcard">%1$s<a class="url fn n" href="%2$s">%3$s</a></span></span>',
			sprintf( _x( '<span class="screen-reader-text">Author</span>', 'Used before post author name.', 'clean-business' ) ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}

	if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'clean-business' ), esc_html__( '1 Comment', 'clean-business' ), esc_html__( '% Comments', 'clean-business' ) );
		echo '</span>';
	}

	$content_layout = apply_filters( 'clean_business_get_option', 'content_layout' );
	if ( is_single() || ( is_archive() && ( 'excerpt-image-top' == $content_layout || 'full-content' == $content_layout ) ) ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'clean-business' ) );
		if ( $categories_list && clean_business_categorized_blog() ) {
			printf( '<span class="cat-links">%1$s%2$s</span>',
						sprintf( _x( '<span class="screen-reader-text">Categories</span>', 'Used before category names.', 'clean-business' ) ),
						$categories_list
					);
		}
	}
}
endif;

if ( ! function_exists( 'clean_business_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function clean_business_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'clean-business' ) );
		if ( $tags_list && is_single() ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i>' . esc_html__( ' %1$s', 'clean-business' ) . '</span>', $tags_list );
		}
	}
	edit_post_link( esc_html__( 'Edit', 'clean-business' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function clean_business_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'clean_business_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'clean_business_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so clean_business_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so clean_business_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in clean_business_categorized_blog.
 */
function clean_business_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'clean_business_categories' );
}
add_action( 'edit_category', 'clean_business_category_transient_flusher' );
add_action( 'save_post',     'clean_business_category_transient_flusher' );

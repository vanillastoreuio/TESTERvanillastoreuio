<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Clean Business
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function clean_business_jetpack_setup() {
	/**
     * Setup Infinite Scroll using JetPack if navigation type is set
     */
    $pagination_type = apply_filters( 'clean_business_get_option', 'pagination_type' );

    if( 'infinite-scroll-click' == $pagination_type ) {
        add_theme_support( 'infinite-scroll', array(
            'type'      => 'click',
            'container' => 'main',
			'footer'    => 'page',
        ) );
    }
    else if ( 'infinite-scroll-scroll' == $pagination_type ) {
        //Override infinite scroll disable scroll option
        update_option('infinite_scroll', true);

        add_theme_support( 'infinite-scroll', array(
            'type'      => 'scroll',
			'container' => 'main',
			'footer'    => 'page',
        ) );
    }

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'clean_business_jetpack_setup' );

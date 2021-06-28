<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Clean Business
 */

/**
 * clean_business_doctype hook
 *
 * @hooked clean_business_doctype -  10
 *
 */
do_action( 'clean_business_doctype' );
?>

<head>
	<?php
	/**
	 * clean_business_before_wp_head hook
	 *
	 * @hooked clean_business_head -  10
	 *
	 */
	do_action( 'clean_business_before_wp_head' );

	wp_head();
	?>
</head>

<body <?php body_class(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}
?>

<?php
	/**
     * clean_business_before_header hook
     *
     * @hooked clean_business_preloader - 10
     *
     */
    do_action( 'clean_business_before' );

	/**
	 * clean_business_header hook
	 *
	 * @hooked clean_business_page_start -  10
	 * @hooked clean_business_featured_overall_image (before-header) - 20
	 * @hooked clean_business_header_start- 30
	 * @hooked clean_business_site_branding - 40
	 * @hooked clean_business_primary_menu - 50
	 * @hooked clean_business_header_end - 100
	 *
	 */
	do_action( 'clean_business_header' );

	/**
     * clean_business_after_header hook
     *
     * @hooked clean_business_featured_overall_image (after-header) - 10
     *
     *
     */
	do_action( 'clean_business_after_header' );

	/**
	 * clean_business_before_content hook
	 *
	 * @hooked clean_business_slider - 10
	 * @hooked clean_business_featured_overall_image (after-slider)  - 20
	 * @hooked clean_business_promotion_headline - 30
	 * @hooked clean_business_featured_content_display (move featured content above homepage posts - default option) - 40
	 * @hooked clean_business_add_breadcrumb - 50
	 */
	do_action( 'clean_business_before_content' );

	/**
     * clean_business_main hook
     *
     *  @hooked clean_business_content_start - 10
     *
     */
	do_action( 'clean_business_content' );
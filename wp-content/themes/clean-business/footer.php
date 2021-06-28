<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Clean Business
 */

/**
 * clean_business_after_content hook
 *
 * @hooked clean_business_content_end - 10
 * @hooked clean_business_featured_content_display (move featured content below homepage posts) - 20
 *
 */
do_action( 'clean_business_after_content' );

/**
 * clean_business_footer hook
 *
 * @hooked clean_business_footer_sidebar - 10
 * @hooked clean_business_scrollup - 20
 * @hooked clean_business_footer_content_start - 30
 * @hooked clean_business_footer_content - 100
 * @hooked clean_business_footer_content_end - 110
 * @hooked clean_business_page_end - 200
 *
 */
do_action( 'clean_business_footer' );

wp_footer(); ?>

</body>
</html>

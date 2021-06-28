<?php
/**
 *
 * @package Clean Business
 */

/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (   ! is_active_sidebar( 'footer-1'  )
	&& ! is_active_sidebar( 'footer-2' )
	&& ! is_active_sidebar( 'footer-3'  )
) {
	return;
}
// If we get this far, we have widgets. Let do this.
?>

<?php
/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Clean Business 0.1
 */
function clean_business_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'footer-1' ) )
		$count++;

	if ( is_active_sidebar( 'footer-2' ) )
		$count++;

	if ( is_active_sidebar( 'footer-3' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'sidebar-column col-md-12';
			break;
		case '2':
			$class = 'sidebar-column col-md-6';
			break;
		case '3':
			$class = 'sidebar-column col-md-4';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
} ?>

<div id="sidebar-footer" class="footer-widgets widget-area" role="complementary">
	<div class="container">
		<div class="row">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div <?php clean_business_footer_sidebar_class(); ?>>
					<?php dynamic_sidebar( 'footer-1'); ?>
				</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div <?php clean_business_footer_sidebar_class(); ?>>
					<?php dynamic_sidebar( 'footer-2'); ?>
				</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div <?php clean_business_footer_sidebar_class(); ?>>
					<?php dynamic_sidebar( 'footer-3'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
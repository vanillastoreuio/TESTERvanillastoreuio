<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

/**
 * clean_business_before_secondary hook
 */
do_action( 'clean_business_before_secondary' );

$clean_business_layout = clean_business_get_theme_layout();

//Bail early if no sidebar layout is selected
if ( 'no-sidebar' == $clean_business_layout ) {
	return;
}

do_action( 'clean_business_before_primary_sidebar' );
?>
<div id="secondary" class="widget-area col-md-4" role="complementary">
	<div class="well">
		<?php
		if ( is_active_sidebar( 'primary-sidebar' ) ) {
        	dynamic_sidebar( 'primary-sidebar' );
   		}
		else {
			//Helper Text
			if ( current_user_can( 'edit_theme_options' ) ) { ?>
				<section id="widget-default-text" class="widget widget_text">
					<div class="widget-wrap">
	                	<h4 class="widget-title"><?php _e( 'Primary Sidebar Widget Area', 'clean-business' ); ?></h4>

	           			<div class="textwidget">
	                   		<p><?php _e( 'This is the Primary Sidebar Widget Area if you are using a two or three column site layout option.', 'clean-business' ); ?></p>
	                   		<p><?php printf( __( 'By default it will load Search and Archives widgets as shown below. You can add widget to this area by visiting your <a href="%s">Widgets Panel</a> which will replace default widgets.', 'clean-business' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
	                 	</div>
	           		</div><!-- .widget-wrap -->
	       		</section><!-- #widget-default-text -->
			<?php
			} ?>
			<section class="widget widget_search" id="default-search">
				<div class="widget-wrap">
					<?php get_search_form(); ?>
				</div><!-- .widget-wrap -->
			</section><!-- #default-search -->
			<section class="widget widget_archive" id="default-archives">
				<div class="widget-wrap">
					<h4 class="widget-title"><?php _e( 'Archives', 'clean-business' ); ?></h4>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</div><!-- .widget-wrap -->
			</section><!-- #default-archives -->
			<?php
		} ?>
	</div><!-- .well -->
</div><!-- #secondary -->
<?php
/**
 * clean_business_after_primary_sidebar hook
 */
do_action( 'clean_business_after_primary_sidebar' );


/**
 * clean_business_after_secondary hook
 *
 */
do_action( 'clean_business_after_secondary' );

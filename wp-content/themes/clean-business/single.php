<?php
/**
 * The template for displaying all single posts.
 *
 * @package Clean Business
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-8">
		<main id="main" class="site-main post-wrap" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php clean_business_the_post_navigation(); ?>

			<?php
				/**
				 * clean_business_comment_section hook
				 *
				 * @hooked clean_business_get_comment_section - 10
				 */
				do_action( 'clean_business_comment_section' );
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

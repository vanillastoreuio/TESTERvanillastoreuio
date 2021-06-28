<?php
/**
 * @package Clean Business
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * clean_business_before_post_container hook
	 *
	 * @hooked clean_business_single_content_image - 10
	 */
	do_action( 'clean_business_before_post_container' );
	?>

	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<div class="meta-post">
			<?php clean_business_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'clean-business' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php clean_business_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

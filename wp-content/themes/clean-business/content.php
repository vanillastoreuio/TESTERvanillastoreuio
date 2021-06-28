<?php
/**
 * @package Clean Business
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * clean_business_before_entry_container hook
	 *
	 * @hooked clean_business_archive_content_image - 10
	 */
	do_action( 'clean_business_before_entry_container' );
	?>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="meta-post">
			<?php clean_business_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php
	$clean_business_content_layout = apply_filters( 'clean_business_get_option', 'content_layout' );

	if ( is_search() || 'full-content' != $clean_business_content_layout ) : // Only display Excerpts for Search and if 'full-content' is not selected ?>
		<div class="entry-summary entry-post">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content entry-post">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links"><span class="pages">' . esc_html__( 'Pages:', 'clean-business' ) . '</span>',
					'after'  => '</div>',
					'link_before' 	=> '<span>',
                    'link_after'   	=> '</span>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php clean_business_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
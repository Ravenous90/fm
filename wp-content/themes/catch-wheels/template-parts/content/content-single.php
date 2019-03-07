<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Catch_Wheels
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php catch_wheels_single_image(); ?>

	<div class="entry-container">
		<div class="entry-content">
			<?php
			the_content( sprintf(
				wp_kses(
					/*translators: %s: Name of current post. Only visible to screen readers*/
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'catch-wheels' ),
					array(
						'span' => array(
							'class' => array(),
							),
						)
					),
				get_the_title()
				) );
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'catch-wheels' ) . '</span>',
				'after'  => '</div>',
				'link_before'     => '<span>',
				'link_after'       => '</span>',
				) );
				?>
			</div> <!-- .entry-content -->

		<footer class="entry-footer">
			<div class="entry-meta">
				<?php catch_wheels_entry_footer(); ?>
			</div><!-- .entry-meta -->
			<?php catch_wheels_author_bio(); ?>
		</footer><!-- .entry-footer -->
	</div> <!-- .entry-container -->
</article><!-- #post-<?php //the_ID(); ?> -->

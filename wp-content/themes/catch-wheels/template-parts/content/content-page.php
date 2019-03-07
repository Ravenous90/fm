<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Catch_Wheels
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php catch_wheels_single_image(); ?>

	<div class="entry-container">

		<?php
		if ( is_front_page() ) : ?>

		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
			<div class="entry-meta">
				<?php catch_wheels_posted_by(); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<?php endif; ?>

		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'catch-wheels' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<div class="entry-meta">
					<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="screen-reader-text">%s</span>', 'catch-wheels' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</div> <!-- .entry-meta -->
			</footer><!-- .entry-footer -->
		<?php endif; ?>
		</div> <!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Catch_Wheels
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
	<div class="hentry-inner">
		<div class="entry-container">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
				<?php endif; ?>

				<div class="entry-meta">
					<?php catch_wheels_posted_by(); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

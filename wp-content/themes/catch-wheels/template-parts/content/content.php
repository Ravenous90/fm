<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Catch_Wheels
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<?php catch_wheels_archive_image(); ?>

		<div class="entry-container">
			<?php if ( is_sticky() ) { ?>
			<span class="sticky-label"><?php esc_html_e( 'Featured', 'catch-wheels' ); ?></span>
			<?php } ?>

			<header class="entry-header">
				<div class="entry-category">
					<?php catch_wheels_entry_category(); ?>
				</div><!-- .entry_category -->

				<?php if ( is_singular() ) :
					the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif; ?>
				
				<div class="entry-meta">
					<?php catch_wheels_posted_by(); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->


			<?php
			$show_content = catch_wheels_get_content_layout();
			if ( 'full-content' === $show_content || 'full-content-image-top' === $show_content ) {
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
				echo '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
			} else {
				echo '<div class="entry-summary"><p>' . get_the_excerpt() . '</p></div><!-- .entry-summary -->';
			} ?>

		</div> <!-- .entry-container -->
	</div> <!-- .hentry-inner -->
</article><!-- #post-<?php //the_ID(); ?> -->

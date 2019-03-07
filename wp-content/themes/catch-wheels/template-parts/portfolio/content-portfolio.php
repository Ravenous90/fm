<?php
/**
 * The template for displaying portfolio posts on the front page
 *
 * @package Catch_Wheels
 */
?>

<?php
$show_content = get_theme_mod( 'catch_wheels_portfolio_show', 'hide-content' );
$layout       = 'layout-four';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<span class="preview-toggle">
					<i class="fa fa-search"></i>

					<span class="view-icon-label screen-reader-text"><?php esc_html_e( 'View', 'catch-wheels' ); ?></span>
				</span>
				<?php
				$thumbnail = 'catch-wheels-portfolio';

				if ( has_post_thumbnail() ) {
					the_post_thumbnail( $thumbnail );
				}
				else {
					$image = '<img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-480x640.jpg"/>';

					if ( 'catch-wheels-service' === $thumbnail ) {
						$image = '<img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-480x480.jpg"/>';
					}

					// Get the first image in page, returns false if there is no image.
					$first_image = catch_wheels_get_first_image( $post->ID, $thumbnail, '' );

					// Set value of image as first image if there is an image present in the page.
					if ( $first_image ) {
						$image = $first_image;
					}

					echo $image;
				}
				?>
			</a>
		</div>

		<div class="entry-container">
			<header class="entry-header">
				
					<div class="entry-category">
						<?php catch_wheels_entry_category(); ?>
					</div>

				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
				<div class="entry-meta">
					<?php catch_wheels_posted_by(); ?>
				</div><!-- .entry-meta -->
			</header>

			<?php
			if ( 'excerpt' === $show_content ) {
				$excerpt = get_the_excerpt();

				echo '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
			} elseif ( 'full-content' === $show_content ) {
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
				echo '<div class="entry-content">' . $content . '</div><!-- .entry-content -->';
			} ?>
		</div><!-- .entry-container -->
	</div> <!-- .hentry-inner -->
</article> <!-- .article -->

<?php
/**
 * Template Name: Video Gallery
 *
 * Template Post Type: page
 *
 * The template for displaying Video Gallery
 *
 * @package Catch_Wheels
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="archive-content-wrap video-post-wrap">
				<?php
				$cols = get_post_meta( get_the_ID(), 'catch-wheels-video-cols', true );

				if ( ! $cols ){
					$cols = 'layout-two';
				}
				?>
				<div id="infinite-post-wrap" class="section-content-wrapper <?php echo esc_attr( $cols ); ?>">
						<?php

						$args = array(
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => 'post-format-video',
								)
							)
						);

						$loop = new WP_Query( $args );

						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) {

								$loop->the_post();

								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="hentry-inner">
										<?php catch_wheels_archive_image(); ?>

										<div class="entry-container">
											<header class="entry-header">
												<?php
												the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

												?>

												<div class="entry-meta">
													<?php catch_wheels_posted_by(); ?>
												</div><!-- .entry-meta -->
											</header><!-- .entry-header -->
										</div> <!-- .entry-container -->
									</div> <!-- .hentry-inner -->
								</article><!-- #post-<?php //the_ID(); ?> -->
							<?php
							}

						    wp_reset_postdata();
						}
						?>
				</div> <!-- .section-content-wrapper -->
			</div><!-- archive-content-wrap -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();

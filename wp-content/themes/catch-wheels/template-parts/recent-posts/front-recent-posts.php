<?php
/**
 * Template part for displaying Recent Posts in the front page template
 *
 * @package Catch_Wheels
 */
?>
<div class="recent-blog-content-wrapper section">
	<div class="wrapper">
		<?php
		$post_title = esc_html__( 'Recent Posts', 'catch-wheels' ) ; ?>
			<div class="section-heading-wrap">
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo esc_html( $post_title ); ?></h2>
				</div> <!-- .section-title-wrapper -->
			</div><!-- .section-heading-wrap -->
		<div class="section-content-wrap">
			<?php
			$recent_posts = new WP_Query( array(
				'ignore_sticky_posts' => true,
			) );

			/* Start the Loop */
			while ( $recent_posts->have_posts() ) :
				$recent_posts->the_post();

				get_template_part( 'template-parts/content/content', get_post_format() );

			endwhile;

			wp_reset_postdata();
			?>
		</div><!-- .section-content-wrap -->

		<p class="more-recent-posts"><span class="more-button"><a class="more-link" href="<?php the_permalink( get_option( 'page_for_posts' ) ); ?>"><?php esc_html_e( 'More Posts', 'catch-wheels' ); ?></a><span></p>
	</div> <!-- .wrapper -->
</div> <!-- .recent-blog-content-wrapper -->

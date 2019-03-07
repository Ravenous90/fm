<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Catch_Wheels
 */

?>

		<?php
		$enable_homepage_posts = catch_wheels_enable_homepage_posts();

		if ( $enable_homepage_posts ) : ?>
			</div><!-- .wrapper -->
		</div><!-- #content -->
		<?php endif; ?>
		<?php get_theme_mod( 'catch_wheels_featured_content_position' ) ? get_template_part( 'template-parts/featured-content/display', 'featured' ) : ''; ?>

		<?php get_theme_mod( 'catch_wheels_events_position' ) ? get_template_part( 'template-parts/events/display', 'events' ) : ''; ?>

		<footer id="colophon" class="site-footer">
			<?php get_template_part( 'template-parts/footer/footer', 'widget' ); ?>

			<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
		</footer><!-- #colophon -->
	</div> <!-- below-site-header -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script src="<?= get_template_directory_uri(); ?>/assets/js/custom-script.js"></script>
<link href="<?= get_template_directory_uri(); ?>/assets/css/custom-styles.css" rel="stylesheet" type="text/css" />
</body>
</html>

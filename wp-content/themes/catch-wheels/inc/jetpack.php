<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Catch_Wheels
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function catch_wheels_jetpack_setup() {
	/**
	 * Setup Infinite Scroll using JetPack if navigation type is set
	 */
	$pagination_type = get_theme_mod( 'catch_wheels_pagination_type', 'default' );

		add_theme_support( 'infinite-scroll', array(
			'container' => 'infinite-post-wrap',
			'render'    => 'catch_wheels_infinite_scroll_render',
			'footer'    => 'page',
			'wrapper'   => false,
		) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'catch_wheels_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function catch_wheels_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content/content', 'search' );
		else :
			get_template_part( 'template-parts/content/content', get_post_format() );
		endif;
	}
}

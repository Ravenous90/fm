<?php
/**
 * Customizer functionality
 *
 * @package Catch_Wheels
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Catch Wheels 0.1
 *
 * @see catch_wheels_header_style()
 */
function catch_wheels_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Catch Wheels.
	 *
	 * @since Catch Wheels 0.1
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'catch_wheels_custom_background_args', array(
		'default-color' => '#333333',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Catch Wheels.
	 *
	 * @since Catch Wheels 0.1
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'catch_wheels_custom_header_args', array(
		'default-image'      	 => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
		'default-text-color'     => '#ffffff',
		'width'                  => 1920,
		'height'                 => 400,
		'flex-height'            => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'catch_wheels_header_style',
		'video'                  => true,
	) ) );

	$default_headers_args = array(
		'main' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
		),
	);

	register_default_headers( $default_headers_args );
}
add_action( 'after_setup_theme', 'catch_wheels_custom_header_and_background' );

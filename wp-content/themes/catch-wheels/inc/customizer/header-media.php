<?php
/**
 * Header Media Options
 *
 * @package Catch_Wheels
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'catch-wheels' );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_header_media_option',
			'default'           => 'exclude-home-page-post',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'catch-wheels' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'catch-wheels' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'catch-wheels' ),
				'entire-site'            => esc_html__( 'Entire Site', 'catch-wheels' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'catch-wheels' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'catch-wheels' ),
				'disable'                => esc_html__( 'Disabled', 'catch-wheels' ),
			),
			'label'             => esc_html__( 'Enable on', 'catch-wheels' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);
}
add_action( 'customize_register', 'catch_wheels_header_media_options' );

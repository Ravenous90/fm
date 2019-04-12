<?php
/**
 * Theme Options
 *
 * @package Catch_Wheels
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'catch_wheels_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'catch-wheels' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'catch_wheels_breadcrumb_options', array(
		'description'   => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'catch-wheels' ),
		'panel'         => 'catch_wheels_theme_options',
		'title'         => esc_html__( 'Breadcrumb', 'catch-wheels' ),
	) );

	catch_wheels_register_option( $wp_customize, array(
			'name'              =>'catch_wheels_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'catch_wheels_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'catch-wheels' ),
			'section'           => 'catch_wheels_breadcrumb_options',
			'type'              => 'checkbox',
	    )
	);
    // Breadcrumb Option End

	// Layout Options
	$wp_customize->add_section( 'catch_wheels_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'catch-wheels' ),
		'panel' => 'catch_wheels_theme_options',
		)
	);

	/* Default Layout */
	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'catch-wheels' ),
			'section'           => 'catch_wheels_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-wheels' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'catch-wheels' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_homepage_archive_layout',
			'default'           => 'no-sidebar',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'catch-wheels' ),
			'section'           => 'catch_wheels_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-wheels' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'catch-wheels' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'catch_wheels_excerpt_options', array(
		'panel' => 'catch_wheels_theme_options',
		'title' => esc_html__( 'Excerpt Options', 'catch-wheels' ),
	) );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_excerpt_length',
			'default'           => '55',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 55 words', 'catch-wheels' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'catch-wheels' ),
			'section'  => 'catch_wheels_excerpt_options',
			'type'     => 'number',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'catch-wheels' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'catch-wheels' ),
			'section'           => 'catch_wheels_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'catch_wheels_search_options', array(
		'panel'     => 'catch_wheels_theme_options',
		'title'     => esc_html__( 'Search Options', 'catch-wheels' ),
	) );

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'catch_wheels_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'catch-wheels' ),
		'panel'       => 'catch_wheels_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'catch-wheels' ),
	) );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_front_page_category',
			'sanitize_callback' => 'catch_wheels_sanitize_category_list',
			'custom_control'    => 'Catch_Wheels_Multi_Cat',
			'label'             => esc_html__( 'Categories', 'catch-wheels' ),
			'section'           => 'catch_wheels_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);
	
	// Pagination Options.
	$wp_customize->add_section( 'catch_wheels_pagination_options', array(
		'panel'       => 'catch_wheels_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'catch-wheels' ),
	) );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'catch-wheels' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'catch_wheels_pagination_options', array(
		'description' => $nav_desc,
		'panel'       => 'catch_wheels_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'catch-wheels' ),
	) );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'choices'           => catch_wheels_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'catch-wheels' ),
			'section'           => 'catch_wheels_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
//	$wp_customize->add_section( 'catch_wheels_scrollup', array(
//		'panel'    => 'catch_wheels_theme_options',
//		'title'    => esc_html__( 'Scrollup Options', 'catch-wheels' ),
//	) );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_disable_scrollup',
			'sanitize_callback' => 'catch_wheels_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'catch-wheels' ),
			'section'           => 'catch_wheels_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_wheels_theme_options' );

/** Active Callback Functions */

if( ! function_exists( 'catch_wheels_is_header_top_enabled' ) ) :
	/**
	* Return true if header top is enabled
	*
	* @since Catch Wheels 0.1
	*/
	function catch_wheels_is_header_top_enabled( $control ) {
		return ( ! $control->manager->get_setting( 'catch_wheels_disable_header_top' )->value() );
	}
endif;
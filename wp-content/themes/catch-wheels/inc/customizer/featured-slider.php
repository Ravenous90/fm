<?php
/**
 * Featured Slider Options
 *
 * @package Catch_Wheels
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'catch_wheels_featured_slider', array(
			'panel' => 'catch_wheels_theme_options',
			'title' => esc_html__( 'Featured Slider', 'catch-wheels' ),
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'choices'           => catch_wheels_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_slider',
			'type'              => 'select',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_slider_number',
			'default'           => '2',
			'sanitize_callback' => 'catch_wheels_sanitize_number_range',

			'active_callback'   => 'catch_wheels_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'catch-wheels' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of items', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_slider',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_exclude_slider_post',
			'sanitize_callback' => 'catch_wheels_sanitize_checkbox',
			'active_callback'   => 'catch_wheels_is_slider_active',
			'label'             => esc_html__( 'Check to exclude Slider post from Homepage posts', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_slider',
			'type'              => 'checkbox',
		)
	);

	$slider_number = get_theme_mod( 'catch_wheels_slider_number', 2 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Post Sliders
		catch_wheels_register_option( $wp_customize, array(
				'name'              =>'catch_wheels_slider_post_' . $i,
				'sanitize_callback' => 'catch_wheels_sanitize_post',
				'active_callback'   => 'catch_wheels_is_slider_active',
				'input_attrs'       => array(
					'style' => 'width: 80px;',
				),
				'label'             => esc_html__( 'Post', 'catch-wheels' ) . ' # ' . $i,
				'section'           => 'catch_wheels_featured_slider',
				'choices'           => catch_wheels_generate_post_array(),
				'type'              => 'select',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'catch_wheels_slider_options' );

/**
 * Returns an array of featured content show registered for Lucida.
 *
 * @since Catch Wheels 0.1
 */
function catch_wheels_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'catch-wheels' ),
		'full-content' => esc_html__( 'Full Content', 'catch-wheels' ),
		'hide-content' => esc_html__( 'Hide Content', 'catch-wheels' ),
	);
	return apply_filters( 'catch_wheels_content_show', $options );
}

/**
 * Returns an array of featured content show registered for Lucida.
 *
 * @since Catch Wheels 0.1
 */
function catch_wheels_meta_show() {
	$options = array(
		'show-meta' => esc_html__( 'Show Meta', 'catch-wheels' ),
		'hide-meta' => esc_html__( 'Hide Meta', 'catch-wheels' ),
	);
	return apply_filters( 'catch_wheels_content_show', $options );
}

/** Active Callback Functions */

if( ! function_exists( 'catch_wheels_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Catch Wheels 0.1
	*/
	function catch_wheels_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'catch_wheels_slider_option' )->value();

		//return true only if previewed page on customizer matches the type of slider option selected
		return ( catch_wheels_check_section( $enable ) );
	}
endif;
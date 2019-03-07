<?php
/**
 * Portfolio options
 *
 * @package Catch_Wheels
 */

/**
 * Add portfolio content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_portfolio_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Portfolio Options for Catch Wheels Theme, go %1$shere%2$s', 'catch-wheels' ),
                '<a href="javascript:wp.customize.section( \'catch_wheels_portfolio\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'catch_wheels_portfolio', array(
			'title' => esc_html__( 'Portfolio', 'catch-wheels' ),
			'panel' => 'catch_wheels_theme_options',
		)
	);

	 catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_testimonials_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_ect_portfolio_inactive',
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Content Type Enabled', 'catch-wheels' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'catch_wheels_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'	=> 'catch_wheels_is_ect_portfolio_active',
			'choices'           => catch_wheels_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
			'type'              => 'select',
		)
	);

    catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_portfolio_active',
            'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-wheels' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'catch_wheels_portfolio',
            'type'              => 'description',
        )
    );

    catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_number',
			'default'           => 4,
			'sanitize_callback' => 'catch_wheels_sanitize_number_range',
			'active_callback'   => 'catch_wheels_is_portfolio_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Items is changed', 'catch-wheels' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_show',
			'default'           => 'hide-content',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'   => 'catch_wheels_is_portfolio_active',
			'choices'           => catch_wheels_content_show(),
			'label'             => esc_html__( 'Display Content', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
			'type'              => 'select',
		)
	);

	$number = get_theme_mod( 'catch_wheels_portfolio_number', 4 );

	//loop for portfolio post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		catch_wheels_register_option( $wp_customize, array(
				'name'              => 'catch_wheels_portfolio_cpt_' . $i,
				'sanitize_callback' => 'catch_wheels_sanitize_post',
				'active_callback'   => 'catch_wheels_is_portfolio_active',
				'label'             => esc_html__( 'Portfolio', 'catch-wheels' ) . ' ' . $i ,
				'section'           => 'catch_wheels_portfolio',
				'type'              => 'select',
                'choices'           => catch_wheels_generate_post_array( 'jetpack-portfolio' ),
			)
		);
	} // End for().

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_text',
			'default'           => esc_html__( 'View All', 'catch-wheels' ),
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'catch_wheels_is_portfolio_active',
			'label'             => esc_html__( 'Button Text', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
			'type'              => 'text',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_link',
			'sanitize_callback' => 'esc_url_raw',
			'active_callback'   => 'catch_wheels_is_portfolio_active',
			'label'             => esc_html__( 'Button Link', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_portfolio_target',
			'sanitize_callback' => 'catch_wheels_sanitize_checkbox',
			'active_callback'   => 'catch_wheels_is_portfolio_active',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'catch-wheels' ),
			'section'           => 'catch_wheels_portfolio',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_wheels_portfolio_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_wheels_is_portfolio_active' ) ) :
	/**
	* Return true if portfolio content is active
	*
	* @since Catch Wheels 0.1
	*/
	function catch_wheels_is_portfolio_active( $control ) {
		$enable = $control->manager->get_setting( 'catch_wheels_portfolio_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( catch_wheels_check_section( $enable ) && catch_wheels_is_ect_portfolio_active( $control ) );
	}
endif;

if ( ! function_exists( 'catch_wheels_is_ect_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'catch_wheels_is_ect_portfolio_inactive' ) ) :
    /**
    * Return true if portfolio is inactive
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'JetPack' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
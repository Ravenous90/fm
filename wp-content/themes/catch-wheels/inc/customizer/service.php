<?php
/**
 * Services options
 *
 * @package Catch_Wheels
 */

/**
 * Add services content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_services_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_services_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options for Catch Wheels Theme, go %1$shere%2$s', 'catch-wheels' ),
                '<a href="javascript:wp.customize.section( \'catch_wheels_services\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'catch_wheels_services', array(
			'title' => esc_html__( 'Services', 'catch-wheels' ),
			'panel' => 'catch_wheels_theme_options',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'catch_wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Content Type Enabled', 'catch-wheels' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'catch_wheels_services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_services_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'	=> 'catch_wheels_is_ect_service_active',
			'choices'           => catch_wheels_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-wheels' ),
			'section'           => 'catch_wheels_services',
			'type'              => 'select',
		)
	);

    catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_services_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_services_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-wheels' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'catch_wheels_services',
            'type'              => 'description',
        )
    );

    catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_services_number',
			'default'           => 4,
			'sanitize_callback' => 'catch_wheels_sanitize_number_range',
			'active_callback'   => 'catch_wheels_is_services_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Items is changed', 'catch-wheels' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'catch-wheels' ),
			'section'           => 'catch_wheels_services',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_services_show',
			'default'           => 'hide-content',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'   => 'catch_wheels_is_services_active',
			'choices'           => catch_wheels_content_show(),
			'label'             => esc_html__( 'Display Content', 'catch-wheels' ),
			'section'           => 'catch_wheels_services',
			'type'              => 'select',
		)
	);

	$number = get_theme_mod( 'catch_wheels_services_number', 4 );

	//loop for services post content
	for ( $i = 1; $i <= $number ; $i++ ) {
		catch_wheels_register_option( $wp_customize, array(
				'name'              => 'catch_wheels_services_cpt_' . $i,
				'sanitize_callback' => 'catch_wheels_sanitize_post',
				'active_callback'   => 'catch_wheels_is_services_active',
				'label'             => esc_html__( 'Services', 'catch-wheels' ) . ' ' . $i ,
				'section'           => 'catch_wheels_services',
				'type'              => 'select',
                'choices'           => catch_wheels_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'catch_wheels_services_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_wheels_is_services_active' ) ) :
	/**
	* Return true if services content is active
	*
	* @since Catch Wheels 0.1
	*/
	function catch_wheels_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'catch_wheels_services_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( catch_wheels_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'catch_wheels_is_ect_service_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'catch_wheels_is_ect_service_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

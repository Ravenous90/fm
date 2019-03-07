<?php
/**
 * Featured Content options
 *
 * @package Catch_Wheels
 */
 
/**
 * Add featured content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_wheels_featured_content_options( $wp_customize ) {
    $wp_customize->add_section( 'catch_wheels_featured_content', array(
			'title' => esc_html__( 'Featured Content', 'catch-wheels' ),
			'panel' => 'catch_wheels_theme_options',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_featured_content_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_ect_featured_content_inactive',
            'label'             => sprintf( esc_html__( 'For Featured Content, install %1$sEssential Content Types%2$s Plugin with Featured Content Type Enabled', 'catch-wheels' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'catch_wheels_featured_content',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_featured_content_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'   => 'catch_wheels_is_ect_featured_content_active',
			'choices'           => catch_wheels_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_content',
			'type'              => 'select',
		)
	);

	 catch_wheels_register_option( $wp_customize, array(
            'name'              => 'catch_wheels_featured_content_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Wheels_Note_Control',
            'active_callback'   => 'catch_wheels_is_featured_content_active',
            'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-wheels' ),
                 '<a href="javascript:wp.customize.control( \'featured_content_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'catch_wheels_featured_content',
            'type'              => 'description',
        )
    );

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_featured_content_position',
			'sanitize_callback' => 'catch_wheels_sanitize_checkbox',
			'active_callback'   => 'catch_wheels_is_featured_content_active',
			'label'             => esc_html__( 'Check to Move above footer', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_content',
			'type'              => 'checkbox',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_featured_content_number',
			'default'           => 3,
			'sanitize_callback' => 'catch_wheels_sanitize_number_range',
			'active_callback'   => 'catch_wheels_is_featured_content_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'catch-wheels' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_content',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	catch_wheels_register_option( $wp_customize, array(
			'name'              => 'catch_wheels_featured_content_show',
			'default'           => 'excerpt',
			'sanitize_callback' => 'catch_wheels_sanitize_select',
			'active_callback'   => 'catch_wheels_is_featured_content_active',
			'choices'           => catch_wheels_content_show(),
			'label'             => esc_html__( 'Display Content', 'catch-wheels' ),
			'section'           => 'catch_wheels_featured_content',
			'type'              => 'select',
		)
	);

	$number = get_theme_mod( 'catch_wheels_featured_content_number', 3 );

	//loop for featured post content
	for ( $i = 1; $i <= $number ; $i++ ) {
		catch_wheels_register_option( $wp_customize, array(
				'name'              => 'catch_wheels_featured_content_cpt_' . $i,
				'sanitize_callback' => 'catch_wheels_sanitize_post',
				'active_callback'   => 'catch_wheels_is_featured_content_active',
				'label'             => esc_html__( 'Featured Content', 'catch-wheels' ) . ' ' . $i ,
				'section'           => 'catch_wheels_featured_content',
				'type'              => 'select',
                'choices'           => catch_wheels_generate_post_array( 'featured-content' ),
			)
		);
	} // End for().

	  catch_wheels_register_option( $wp_customize, array( 
      'name'              => 'catch_wheels_featured_content_text', 
      'default'           => esc_html__( 'View All', 'catch-wheels' ), 
      'sanitize_callback' => 'sanitize_text_field', 
      'active_callback'   => 'catch_wheels_is_featured_content_active', 
      'label'             => esc_html__( 'Button Text', 'catch-wheels' ), 
      'section'           => 'catch_wheels_featured_content', 
      'type'              => 'text', 
    ) 
  ); 
 
  catch_wheels_register_option( $wp_customize, array( 
      'name'              => 'catch_wheels_featured_content_link', 
      'sanitize_callback' => 'esc_url_raw', 
      'active_callback'   => 'catch_wheels_is_featured_content_active', 
      'label'             => esc_html__( 'Button Link', 'catch-wheels' ), 
      'section'           => 'catch_wheels_featured_content', 
    ) 
  ); 
 
  catch_wheels_register_option( $wp_customize, array( 
      'name'              => 'catch_wheels_featured_content_target', 
      'sanitize_callback' => 'catch_wheels_sanitize_checkbox', 
      'active_callback'   => 'catch_wheels_is_featured_content_active', 
      'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'catch-wheels' ), 
      'section'           => 'catch_wheels_featured_content', 
      'type'              => 'checkbox', 
    ) 
  ); 
}
add_action( 'customize_register', 'catch_wheels_featured_content_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_wheels_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Catch Wheels 0.1
	*/
	function catch_wheels_is_featured_content_active( $control ) {
		$enable = $control->manager->get_setting( 'catch_wheels_featured_content_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( catch_wheels_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'catch_wheels_is_ect_featured_content_active' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_featured_content_active( $control ) {
        return ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;

if ( ! function_exists( 'catch_wheels_is_ect_featured_content_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Catch Wheels 0.1
    */
    function catch_wheels_is_ect_featured_content_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;

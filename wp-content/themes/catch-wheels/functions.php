<?php
/**
 * Catch Wheels functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Catch_Wheels
 */

require get_template_directory() . "/src/start_ajax_actions.php";

if ( ! function_exists( 'catch_wheels_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function catch_wheels_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Catch Wheels, use a find and replace
		 * to change 'catch-wheels' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'catch-wheels', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', array( 'video' ) );

		set_post_thumbnail_size( 470, 353, true );  // Standard Monitor 4:3 Image Ratio

		// Used in Featured Slider, Promotion Heading
		add_image_size( 'catch-wheels-slider', 1920, 822, true );  // Cinema Scope 21:9 Image Ratio

		// Used in Services Section and Event Section
		add_image_size( 'catch-wheels-service', 480, 480, true ); // 1:1 Image Ratio

		// Used in Hero Content Section, archive content top and video gallery
		add_image_size( 'catch-wheels-hero-content', 730, 547, true ); // Standard Monitor 4:3 Image Ratio

		// Used in Portfolio Section
		add_image_size( 'catch-wheels-portfolio', 480, 640, true ); // 3:4 Image Ratio

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1'        => esc_html__( 'Primary', 'catch-wheels' ),
			'social-footer' => esc_html__( 'Social On Footer', 'catch-wheels' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_editor_style( array( 'assets/css/editor-style.css', catch_wheels_fonts_url() ) );

		/**
		 * Add post formats support for Custom post types form Essential Content Types plugin
		 */
    	add_post_type_support( 'ect-service', 'post-formats' );
    	add_post_type_support( 'featured-content', 'post-formats' );
	}
endif;
add_action( 'after_setup_theme', 'catch_wheels_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function catch_wheels_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'catch_wheels_content_width', 1040 );
}
add_action( 'after_setup_theme', 'catch_wheels_content_width', 0 );

if ( ! function_exists( 'catch_wheels_template_redirect' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet for different value other than the default one
	 *
	 * @global int $content_width
	 */
	function catch_wheels_template_redirect() {
		$layout = catch_wheels_get_theme_layout();

		if ( 'no-sidebar-full-width' === $layout ) {
			$GLOBALS['content_width'] = 1520;
		}
	}
endif;
add_action( 'template_redirect', 'catch_wheels_template_redirect' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function catch_wheels_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'catch-wheels' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'catch-wheels' ),
		'before_widget' => '<div class="widget-wrap"><section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section></div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'catch-wheels' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-wheels' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'catch-wheels' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-wheels' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'catch-wheels' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-wheels' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'catch_wheels_widgets_init' );

if ( ! function_exists( 'catch_wheels_fonts_url' ) ) :
	/**
	 * Register Google fonts for Verity Pro.
	 *
	 * Create your own catch_wheels_fonts_url() function to override in a child theme.
	 *
	 * @since Catch Wheels 0.1
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function catch_wheels_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Montserrat, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$noto_sans = _x( 'on', 'Noto Sans: on or off', 'catch-wheels' );

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$rock_salt = _x( 'on', 'Rock Salt font: on or off', 'catch-wheels' );

		if ( 'off' !== $noto_sans || 'off' !== $rock_salt ) {
			$font_families = array();

			if ( 'off' !== $noto_sans ) {
			$font_families[] = 'Noto Sans::400,700';
			}

			if ( 'off' !== $rock_salt ) {
			$font_families[] = 'Rock Salt::400,700';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

/**
 * Add preconnect for Google Fonts.
 */
function catch_wheels_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'catch-wheels-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'catch_wheels_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function catch_wheels_scripts() {
	wp_enqueue_style( 'catch-wheels-fonts', catch_wheels_fonts_url(), array(), null );

	wp_enqueue_style( 'font-awesome', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/css/font-awesome/css/font-awesome.css', array(), '4.7.0', 'all' );

	wp_enqueue_style( 'catch-wheels-style', get_stylesheet_uri() );

	wp_register_script( 'jquery-match-height', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.matchHeight.min.js', array( 'jquery' ), '20171226', true );

	wp_enqueue_script( 'catch-wheels-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/navigation.min.js', array(), '20171226', true );

	wp_enqueue_script( 'catch-wheels-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/skip-link-focus-fix.min.js', array(), '20171226', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//Slider Scripts
	$enable_slider = catch_wheels_check_section( get_theme_mod( 'catch_wheels_slider_option', 'homepage' ) );
	if ( $enable_slider ) {
		wp_register_script( 'jquery-cycle2', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

			$transition_effects = 'fade';
			wp_enqueue_script( 'jquery-cycle2' );

	}

	// Enqueue fitvid if JetPack is not installed.
	if ( ! class_exists( 'Jetpack' ) ) {
		wp_enqueue_script( 'jquery-fitvids', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/fitvids.min.js', array( 'jquery' ), '1.1', true );
	}
}
add_action( 'wp_enqueue_scripts', 'catch_wheels_scripts' );

if ( ! function_exists( 'catch_wheels_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Catch Wheels 0.1
	 */
	function catch_wheels_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options
		$length	= get_theme_mod( 'catch_wheels_excerpt_length', 30 );
		return absint( $length );
	}
endif; //catch_wheels_excerpt_length
add_filter( 'excerpt_length', 'catch_wheels_excerpt_length', 999 );

if ( ! function_exists( 'catch_wheels_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer.
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function catch_wheels_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text	= get_theme_mod( 'catch_wheels_excerpt_more_text',  esc_html__( 'Continue reading', 'catch-wheels' ) );

		$link = sprintf( '<span class="more-button"><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

		return $link;
	}
endif;
add_filter( 'excerpt_more', 'catch_wheels_excerpt_more' );


if ( ! function_exists( 'catch_wheels_custom_excerpt' ) ) :
	/**
	 * Adds Continue reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Catch Wheels 0.1
	 */
	function catch_wheels_custom_excerpt( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = get_theme_mod( 'catch_wheels_excerpt_more_text', esc_html__( 'Continue reading', 'catch-wheels' ) );

			$link = sprintf( '<span class="more-button"><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

			$link = ' &hellip; ' . $link;

			$output .= $link;
		}

		return $output;
	}
endif; //catch_wheels_custom_excerpt
add_filter( 'get_the_excerpt', 'catch_wheels_custom_excerpt' );


if ( ! function_exists( 'catch_wheels_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Catch Wheels 0.1
	 */
	function catch_wheels_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'catch_wheels_excerpt_more_text', esc_html__( 'Continue reading', 'catch-wheels' ) );

		return ' &hellip; ' . str_replace( $more_link_text, $more_tag_text, $more_link );
	}
endif; //catch_wheels_more_link
add_filter( 'the_content_more_link', 'catch_wheels_more_link', 10, 2 );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Catch Wheels 0.1
 */
function catch_wheels_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-5' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class ) {
		echo 'class="widget-area footer-widget-area ' . $class . '"'; // WPCS: XSS OK.
	}
}

/**
 * Implement the Custom Header feature
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Include Header Background Color Options
 */
require get_parent_theme_file_path( 'inc/header-background-color.php' );

/**
 * Custom template tags for this theme
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions
 */
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Featured Slider
 */
require get_parent_theme_file_path( '/inc/featured-slider.php' );

/**
 * Breadcrumb
 */
require get_parent_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Metabox Options
 */
require get_parent_theme_file_path( '/inc/metabox/metabox.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path( '/inc/jetpack.php' );
}
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function catch_wheels_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools',
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs',
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top',
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery',
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll',
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types',
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets',
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget',
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'catch-wheels',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'catch_wheels_register_required_plugins' );

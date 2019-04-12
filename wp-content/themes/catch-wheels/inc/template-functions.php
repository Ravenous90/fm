<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Catch_Wheels
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function catch_wheels_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
		$classes[] = 'navigation-classic';

	// Adds a class with respect to layout selected.
	$layout  = catch_wheels_get_theme_layout();
	$sidebar = catch_wheels_get_sidebar_id();

	if ( 'no-sidebar' === $layout ) {
		$classes[] = 'no-sidebar content-width-layout';
	}
	elseif ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	// Adds a class of full-width to blogs.
		$classes[] = 'fluid-layout';

	$header_image = catch_wheels_featured_overall_image();

	if ( '' == $header_image ) {
		$classes[] = 'no-header-media-image';
	}
	
		//$classes[] = 'no-header-media-text';

	$classes[] = catch_wheels_get_content_layout();

	return $classes;
}
add_filter( 'body_class', 'catch_wheels_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function catch_wheels_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'catch_wheels_pingback_header' );

if ( ! function_exists( 'catch_wheels_comments' ) ) :
	/**
	 * Enable/Disable Comments
	 *
	 * @uses comment_form_default_fields filter
	 * @since Simple Persona Pro 1.0
	 */
	function catch_wheels_comments( $open, $post_id ) {
		$comment_select = 'use-wordpress-setting';
	    return $open;
	}
endif; // catch_wheels_comments.
add_filter( 'comments_open', 'catch_wheels_comments', 10, 2 );

if ( ! function_exists( 'catch_wheels_comment_form_fields' ) ) :
	/**
	 * Modify Comment Form Fields
	 *
	 * @uses comment_form_default_fields filter
	 * @since Personal Trainer Pro 1.0
	 */
	function catch_wheels_comment_form_fields( $fields ) {
		$disable_website = get_theme_mod( 'catch_wheels_website_field' );

		if ( isset( $fields['url'] ) && $disable_website ) {
			unset( $fields['url'] );
		}

		return $fields;
	}
endif; // catch_wheels_comment_form_fields.
add_filter( 'comment_form_default_fields', 'catch_wheels_comment_form_fields' );

/**
 * Adds custom Image overlay for slider image
 */
function catch_wheels_slider_overlay_css() {
	$overlay = get_theme_mod( 'catch_wheels_slider_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
		$css = '.slider-content-wrapper .slider-image::before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' ); } '; // Dividing by 100 as the option is shown as % for user
	}

	wp_add_inline_style( 'catch-wheels-style', $css );
}
add_action( 'wp_enqueue_scripts', 'catch_wheels_slider_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function catch_wheels_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'catch_wheels_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

		if ( get_theme_mod( 'catch_wheels_exclude_slider_post' ) ) {
			$quantity = get_theme_mod( 'catch_wheels_slider_number', 2 );

			$post_list	= array();	// list of valid post ids

			for( $i = 1; $i <= $quantity; $i++ ){
				if ( get_theme_mod( 'catch_wheels_slider_post_' . $i ) && get_theme_mod( 'catch_wheels_slider_post_' . $i ) > 0 ) {
					$post_list = array_merge( $post_list, array( get_theme_mod( 'catch_wheels_slider_post_' . $i ) ) );
				}
			}

			if ( ! empty( $post_list ) ) {
				$query->query_vars['post__not_in'] = $post_list;
			}
		}
	}
}
add_action( 'pre_get_posts', 'catch_wheels_alter_home' );

/**
 * Function to add Scroll Up icon
 */
//function catch_wheels_scrollup() {
//	$disable_scrollup = get_theme_mod( 'catch_wheels_disable_scrollup' );
//
//	if ( $disable_scrollup ) {
//		return;
//	}
//
//	echo '
//		<div class="scrollup">
//			<a href="#masthead" id="scrollup" class="fa fa-sort-asc" aria-hidden="true"><span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'catch-wheels' ) . '</span></a>
//		</div>' ;
//}
//add_action( 'wp_footer', 'catch_wheels_scrollup', 1 );

if ( ! function_exists( 'catch_wheels_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Personal Trainer Pro 1.0
	 */
	function catch_wheels_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'catch_wheels_pagination_type', 'default' );

		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			the_posts_navigation();
		} elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous', 'catch-wheels' ),
				'next_text'          => esc_html__( 'Next', 'catch-wheels' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'catch-wheels' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // catch_wheels_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function catch_wheels_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = absint( $wp_query->get_queried_object_id() );

	// Front page displays in Reading Settings
	$page_for_posts = absint( get_option( 'page_for_posts' ) );

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && $page_for_posts !== $page_id ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Personal Trainer Pro 1.0
 */

function catch_wheels_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field( 'post_content', $postID ) , $matches );

	if( isset( $matches[1][0] ) ) {
		//Get first image
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="pngfix wp-post-image" src="' . $first_img . '">';
	}

	return false;
}

/**
 * Return current theme layout with respect to the page template chosen, or default layout chosen including separate layout for WooCommerce
 * @return string Layout
 */
function catch_wheels_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} elseif ( is_page_template( 'templates/video-gallery.php' ) ) {
		$layout = get_post_meta( get_the_ID(), 'catch-wheels-video-layout', true );

		if ( ! $layout ){
			$layout = 'layout-two';
		}
	} else {
		$layout = get_theme_mod( 'catch_wheels_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() || is_search() ) {
			$layout = get_theme_mod( 'catch_wheels_homepage_archive_layout', 'no-sidebar' );
		}
	}

	return $layout;
}

/**
 * Return current theme content layout with respect to the page template chosen
 * @return string Layout
 */
function catch_wheels_get_content_layout() {
	$layout = 'excerpt-image-right';

	/**
	 * If Page Template is Video Gallery, content layout is always Excerpt Image Top
	 */
	if ( is_page_template( 'templates/video-gallery.php' ) ) {
		$layout = 'excerpt-image-top';
	}

	return $layout;
}

function catch_wheels_get_sidebar_id() {
	$sidebar = '';

	$layout = catch_wheels_get_theme_layout();

	$sidebaroptions = '';

	if ( 'no-sidebar-full-content-width' === $layout || 'no-sidebar-full-width' === $layout || 'no-sidebar' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}
	return $sidebar;
}

/**
 * Get Featured Posts
 */
function catch_wheels_get_posts( $section ) {
	$type   = get_theme_mod( 'catch_wheels_featured_content_type', 'demo' );
	$number = get_theme_mod( 'catch_wheels_featured_content_number', 3 );

	if ( 'featured_content' === $section ) {
		$type     = 'featured-content';
		$number   = get_theme_mod( 'catch_wheels_featured_content_number', 3 );
		$cpt_slug = 'featured-content';
	} elseif ( 'services' === $section ) {
		$type     = 'ect-service';
		$number   = get_theme_mod( 'catch_wheels_services_number', 4 );
		$cpt_slug = 'ect-service';
	} elseif ( 'portfolio' === $section ) {
		$type     = 'jetpack-portfolio';
		$number   = get_theme_mod( 'catch_wheels_portfolio_number', 4 );
		$cpt_slug = 'jetpack-portfolio';
	} 
	
	$post_list  = array();
	$no_of_post = 0;

	$args = array(
		'post_type'           => 'post',
		'ignore_sticky_posts' => 1, // ignore sticky posts.
	);

	// Get valid number of posts.
	if ( 'post' === $type || 'page' === $type || $cpt_slug === $type ) {
		$args['post_type'] = $type;

		for ( $i = 1; $i <= $number; $i++ ) {
			$post_id = '';

			if ( 'post' === $type ) {
				$post_id = get_theme_mod( 'catch_wheels_' . $section . '_post_' . $i );
			} elseif ( 'page' === $type ) {
				$post_id = get_theme_mod( 'catch_wheels_' . $section . '_page_' . $i );
			} elseif ( $cpt_slug === $type ) {
				$post_id = get_theme_mod( 'catch_wheels_' . $section . '_cpt_' . $i );
			}

			if ( $post_id && '' !== $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;
		$args['orderby']  = 'post__in';
	} elseif ( 'category' === $type ) {
		if ( $cat = get_theme_mod( 'catch_wheels_' . $section . '_select_category' ) ) {
			$args['category__in'] = $cat;
		}


		$no_of_post = $number;
	}

	$args['posts_per_page'] = $no_of_post;

	if( ! $no_of_post ) {
		return;
	}

	$posts = get_posts( $args );

	return $posts;
}

if ( ! function_exists( 'catch_wheels_enable_homepage_posts' ) ) :
	/**
	 * Determine Homepage Content disabled or not
	 * @return boolean
	 */
	function catch_wheels_enable_homepage_posts() {
	   if ( ! ( get_theme_mod( 'catch_wheels_disable_homepage_posts' ) && is_front_page() ) ) {
			return true;
		}
		return false;
	}
endif; // catch_wheels_enable_homepage_posts.

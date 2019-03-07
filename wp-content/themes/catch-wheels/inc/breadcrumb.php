<?php
/**
 * Display Breadcrumb
 *
 * @package Catch_Wheels
 */

if ( ! function_exists( 'catch_wheels_breadcrumb' ) ) :
	function catch_wheels_breadcrumb() {
		/* === OPTIONS === */
		$text['home']     = esc_html__( 'Home', 'catch-wheels' ); // text for the 'Home' link
		/* translators: 1: before text/html, 2: after text/html. */
		$text['category'] = esc_html__( '%1$s Archive for %2$s', 'catch-wheels' ); // text for a category page
		/* translators: 1: before text/html, 2: after text/html. */
		$text['search']   = esc_html__( '%1$sSearch results for: %2$s', 'catch-wheels' ); // text for a search results page
		/* translators: 1: before text/html, 2: after text/html. */
		$text['tag']      = esc_html__( '%1$sPosts tagged %2$s', 'catch-wheels' ); // text for a tag page
		/* translators: 1: before text/html, 2: after text/html. */
		$text['author']   = esc_html__( '%1$sView all posts by %2$s', 'catch-wheels' ); // text for an author page
		$text['404']      = esc_html__( 'Error 404', 'catch-wheels' ); // text for the 404 page

		$before = '<span class="breadcrumb-current">'; // tag before the current crumb
		$after  = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post, $paged, $page;
		$linkBefore = '<span class="breadcrumb" typeof="v:Breadcrumb">';
		$linkAfter  = '</span>';
		$linkAttr   = ' rel="v:url" property="v:title"';
		$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;


		if ( ! is_front_page() ) {
			echo '<div class="breadcrumb-area custom">
			<div class="wrapper">
				<nav class="entry-breadcrumbs">';

			echo sprintf( $link, esc_url( home_url( '/' ) ), $text['home'] ); // WPCS: XSS OK.

			if ( is_home() ) {
				echo $before . esc_html( get_the_title( get_option( 'page_for_posts', true ) ) ) . $after; // WPCS: XSS OK.
			} elseif ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );

				if ( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, true, false );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats; // WPCS: XSS OK.
				}

				the_archive_title( $before . sprintf( $text['category'], '<span class="archive-text">', '</span>' ), $after );

			} elseif ( is_search() ) {
				echo $before . sprintf( $text['search'], '<span class="search-text">', '</span>' . get_search_query() ) . $after; // WPCS: XSS OK.

			} elseif ( is_day() ) {
				echo sprintf( $link, esc_url( get_year_link( get_the_time( __( 'Y', 'catch-wheels' ) ) ) ), esc_html( get_the_time( __( 'Y', 'catch-wheels' ) ) ) ) ; // WPCS: XSS OK.


				echo sprintf( $link, esc_url( get_month_link( get_the_time( __( 'Y', 'catch-wheels' ) ) ) ), esc_html(get_the_time( __( 'F', 'catch-wheels' ) ) ) ); // WPCS: XSS OK.

				echo $before . esc_html( get_the_time( __( 'd', 'catch-wheels' ) ) ) . $after; // WPCS: XSS OK.

			} elseif ( is_month() ) {
				echo sprintf( $link, esc_url( get_year_link( get_the_time( __( 'Y', 'catch-wheels' ) ) ) ), esc_html( get_the_time( __( 'Y', 'catch-wheels' ) ) ) ) ; // WPCS: XSS OK.

				echo $before . esc_html( get_the_time( __( 'F', 'catch-wheels' ) ) ) . $after; // WPCS: XSS OK.


			} elseif ( is_year() ) {
				echo $before . esc_html( get_the_time( __( 'Y', 'catch-wheels' ) ) ) . $after; // WPCS: XSS OK.


			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$post_link = get_post_type_archive_link( $post_type->name );

					printf( $link, esc_url( $post_link ), esc_html( $post_type->labels->singular_name ) ); // WPCS: XSS OK.

					echo $before . esc_html( get_the_title() ) . $after; // WPCS: XSS OK.
				}
				else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, '' );
					$cats = preg_replace( "#^(.+)$#", "$1", $cats );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;  // WPCS: XSS OK.

					echo $before . esc_html( get_the_title() ) . $after;  // WPCS: XSS OK.
				}
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo isset( $post_type->labels->singular_name ) ? $before . esc_html( $post_type->labels->singular_name ) . $after : '';  // WPCS: XSS OK.
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );

				if ( isset( $cat[0] ) ) {
					$cat = $cat[0];
				}

				if ( $cat ) {
					$cats = get_category_parents( $cat, true );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats; // WPCS: XSS OK.
				}

				printf( $link, esc_url( get_permalink( $parent ) ), esc_html( $parent->post_title ) ); // WPCS: XSS OK.

				echo $before . esc_html( get_the_title() ) . $after; // WPCS: XSS OK.
			} elseif ( is_page() && ! $post->post_parent ) {
				echo $before . esc_html( get_the_title() ) . $after; // WPCS: XSS OK.
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();

				while( $parent_id ) {
					$page_child    = get_post( $parent_id );
					$breadcrumbs[] = sprintf( $link, esc_url( get_permalink( $page_child->ID ) ), esc_html( get_the_title( $page_child->ID ) ) );
					$parent_id     = $page_child->post_parent;
				}

				$breadcrumbs = array_reverse( $breadcrumbs );

				for( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[$i];  // WPCS: XSS OK.
				}

				echo $before . esc_html( get_the_title() ) . $after; // WPCS: XSS OK.
			} elseif ( is_tag() ) {
				the_archive_title( $before . sprintf( $text['tag'], '<span class="tag-text">', '</span>' ), $after );

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . sprintf( $text['author'], '<span class="author-text">', '</span>' . $userdata->display_name ) . $after;  // WPCS: XSS OK.

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;  // WPCS: XSS OK.

			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}

				/* translators: %s: current page number. */
				echo sprintf( esc_html__( 'Page %s', 'catch-wheels' ), absint( max( $paged, $page ) ) );

				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}

			echo '</nav><!-- .entry-breadcrumbs -->
			</div> <!-- .wrapper -->
			</div><!-- .breadcrumb-area -->';
		}
	} // end catch_wheels_breadcrumb_lists
endif;

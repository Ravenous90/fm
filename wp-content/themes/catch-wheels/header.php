<?php
/**
* The header for our theme
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package Catch_Wheels
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!--     скрипты нельзя так подключать-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'catch-wheels' ); ?></a>

		<header id="masthead" class="site-header">
			<div class="site-header-main">
				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

				<?php get_template_part( 'template-parts/header/site', 'navigation' ); ?>
			</div> <!-- .site-header-main -->
		</header><!-- #masthead -->

		<div class="below-site-header">

			<div class="site-overlay"><span class="screen-reader-text"><?php esc_html_e( 'Site Overlay', 'catch-wheels' ); ?></span></div>

			<?php get_template_part( 'template-parts/slider/content', 'display' ); ?>

			<?php get_template_part( 'template-parts/header/breadcrumb' ); ?>

			<?php get_template_part( 'template-parts/header/header', 'media' ); ?>

			<?php  get_template_part( 'template-parts/services/display', 'services' ); ?>

			<?php ! get_theme_mod( 'catch_wheels_featured_content_position' ) ? get_template_part( 'template-parts/featured-content/display', 'featured' ) : ''; ?>

			<?php get_template_part( 'template-parts/portfolio/display', 'portfolio' ); ?>

			<?php
			$enable_homepage_posts = catch_wheels_enable_homepage_posts();

			if ( $enable_homepage_posts ) : ?>
			<div id="content" class="site-content">
				<div class="wrapper">
			<?php endif; ?>

<?php
/**
 * Display Breadcrumb
 *
 * @package Catch_Wheels
 */
?>

<?php

if ( ! get_theme_mod( 'catch_wheels_breadcrumb_option', 1 ) ) {
	return false;
}

catch_wheels_breadcrumb();
